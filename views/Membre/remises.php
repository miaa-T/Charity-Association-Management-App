<?php
session_start(); // Start the session
$current_page = basename($_SERVER['PHP_SELF']); // Get the current page name
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Remises et Avantages</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <!-- Navbar -->
    <?php include 'navbar.php'; ?>

    <?php
    require_once __DIR__ . '/../../controllers/RemisesController.php';
    $controller = new RemisesController();

    $search = $_GET['search'] ?? '';
    $category = $_GET['category'] ?? '';
    $type = $_GET['type'] ?? '';

    // Fetch categories and filtered offers
    $categories = $controller->getCategories();
    $limitedOffers = $controller->getLimitedOffers($search, $category, $type);
    $permanentOffers = $controller->getPermanentOffers($search, $category, $type);
    ?>

    <!-- Discounts and Advantages Section -->
    <main class="discounts-page-section">
        <div class="search-filter-container">
            <input type="text" id="search-input" class="search-input" placeholder="Rechercher..." value="<?= htmlspecialchars($search) ?>">

            <!-- Dropdown for Categories -->
            <select id="category-filter" class="filter-dropdown">
                <option value="">Select Category</option>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?= htmlspecialchars($cat['id']) ?>" <?= $category == $cat['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($cat['nom']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <!-- Dropdown for Discount Types -->
            <select id="type-filter" class="filter-dropdown">
                <option value="">Select Discount Type</option>
                <option value="permanente" <?= $type === 'permanente' ? 'selected' : '' ?>>Permanente</option>
                <option value="limitee" <?= $type === 'limitee' ? 'selected' : '' ?>>Limitée</option>
            </select>

            <!-- Buttons -->
            <button id="search-btn" class="filter-btn"><i class="fa fa-search"></i> Rechercher</button>
            <button id="apply-filters-btn" class="filter-btn"><i class="fa fa-filter"></i> Appliquer Filtres</button>
        </div>
         <!-- Results Container -->
         <div class="results-container">
            <!-- Results will be dynamically populated here -->
            <p>Use the search bar and filters to view discounts and offers.</p>
        </div>
        <!-- Limited Time Offers -->
        <section class="limited-offers-section">
            <h2>Offres Limitées</h2>
            <div class="limited-offers-container">
                <?php foreach ($limitedOffers as $offer): ?>
                    <div class="limited-offer-card">
                        <div class="limited-offer-header">
                            <span class="offer-expiry">
                                <i class="fa fa-clock-o"></i> Expire dans 
                                <?= isset($offer['expire_le']) ? (strtotime($offer['expire_le']) - strtotime(date('Y-m-d'))) / 86400 : 'N/A'; ?> jours
                            </span>
                        </div>
                        <br><br>
                        <div class="limited-offer-body">
                            <h4><?= htmlspecialchars($offer['nom']); ?></h4>
                            <p>Partenaire : <?= htmlspecialchars($offer['partenaire_nom']); ?></p>
                            <p class="offer-discount"><?= htmlspecialchars($offer['valeur_remise']); ?></p>
                            <p><?= htmlspecialchars($offer['description']); ?></p>
                            <button class="offer-btn" onclick="showOfferPopup(
                        '<?= htmlspecialchars($offer['nom']); ?>',
                        '<?= htmlspecialchars($offer['partenaire_nom']); ?>',
                        '<?= htmlspecialchars($offer['valeur_remise']); ?>',
                        '<?= htmlspecialchars($offer['description']); ?>',
                        '<?= isset($offer['expire_le']) ? htmlspecialchars($offer['expire_le']) : 'N/A'; ?>'
                    )">Voir l'offre</button>                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>

        <!-- Permanent Discounts -->
        <section class="permanent-discounts-section">
            <h2>Remises Permanentes</h2>
            <div class="permanent-discounts-container">
                <?php foreach ($permanentOffers as $offer): ?>
                    <div class="permanent-discount-card">
                        <h4><?= htmlspecialchars($offer['nom']); ?></h4>
                        <p>Partenaire : <?= htmlspecialchars($offer['partenaire_nom']); ?></p>
                        <p class="discount-value"><?= htmlspecialchars($offer['valeur_remise']); ?></p>
                        <p><?= htmlspecialchars($offer['description']); ?></p>
                        <button class="offer-btn" onclick="showOfferPopup(
                        '<?= htmlspecialchars($offer['nom']); ?>',
                        '<?= htmlspecialchars($offer['partenaire_nom']); ?>',
                        '<?= htmlspecialchars($offer['valeur_remise']); ?>',
                        '<?= htmlspecialchars($offer['description']); ?>')">Voir l'offre</button>                    </div>
                <?php endforeach; ?>
            </div>
        </section>
        <!-- Popup pour afficher les détails de l'offre -->
<div id="offerPopup" class="popup">
    <div class="popup-content">
        <span class="close-btn" onclick="closePopup()">&times;</span>
        <h2 id="popupTitle"></h2>
        <p><strong>Partenaire :</strong> <span id="popupPartner"></span></p>
        <p><strong>Valeur de la remise :</strong> <span id="popupDiscount"></span></p>
        <p><strong>Description :</strong> <span id="popupDescription"></span></p>
        <p><strong>Date d'expiration :</strong> <span id="popupExpiry"></span></p>
    </div>
</div>
    </main>

 <!-- Footer -->
 <?php include 'footer.php'; ?>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        const searchBtn = document.getElementById("search-btn");
        const applyFiltersBtn = document.getElementById("apply-filters-btn");
        const resultsContainer = document.querySelector(".results-container");

        function fetchResults() {
    const search = document.getElementById("search-input").value;
    const category = document.getElementById("category-filter").value;
    const type = document.getElementById("type-filter").value;

    const resultsContainer = document.querySelector(".results-container");

    if (!resultsContainer) {
        console.error("Results container not found!");
        return;
    }

    // Print the input values in the console
    console.log("Inputs for request:");
    console.log(`Search Input: ${search}`);
    console.log(`Category Input: ${category}`);
    console.log(`Type Input: ${type}`);

    // Prepare the AJAX request
    const xhr = new XMLHttpRequest();
    const requestURL = `remises-handler.php?search=${encodeURIComponent(search)}&category=${encodeURIComponent(category)}&type=${encodeURIComponent(type)}`;
    xhr.open("GET", requestURL, true);

    xhr.onload = function () {
        if (xhr.status === 200) {
            setTimeout(() => {
                resultsContainer.innerHTML = xhr.responseText;
            }, 2000);
        } else {
            setTimeout(() => {
                resultsContainer.innerHTML = `
                    <p>An error occurred. Please try again.</p>
                    <p><strong>Status Code:</strong> ${xhr.status}</p>
                    <p><strong>Status Text:</strong> ${xhr.statusText}</p>
                    <p><strong>Response:</strong> ${xhr.responseText}</p>
                    <p><strong>Inputs:</strong> Search: "${search}", Category: "${category}", Type: "${type}"</p>
                    <p><strong>Request URL:</strong> ${requestURL}</p>
                `;
                console.error("XHR Error:", {
                    status: xhr.status,
                    statusText: xhr.statusText,
                    response: xhr.responseText,
                    searchInput: search,
                    categoryInput: category,
                    typeInput: type,
                    requestURL: requestURL
                });
            }, 2000);
        }
    };

    xhr.onerror = function () {
        setTimeout(() => {
            resultsContainer.innerHTML = `
                <p>An error occurred while connecting to the server.</p>
                <p><strong>Inputs:</strong> Search: "${search}", Category: "${category}", Type: "${type}"</p>
                <p><strong>Request URL:</strong> ${requestURL}</p>
            `;
            console.error("XHR Connection Error", {
                searchInput: search,
                categoryInput: category,
                typeInput: type,
                requestURL: requestURL
            });
        }, 2000);
    };

    resultsContainer.innerHTML = `<p>Loading...</p>`;
    xhr.send();
}


        // Attach event listeners
        searchBtn.addEventListener("click", fetchResults);
        applyFiltersBtn.addEventListener("click", fetchResults);
    });
   
    // Fonction pour afficher le popup avec les détails de l'offre
    function showOfferPopup(nom, partenaire, valeur, description, expire_le) {
        // Remplir les informations dans le popup
        document.getElementById('popupTitle').textContent = nom;
        document.getElementById('popupPartner').textContent = partenaire;
        document.getElementById('popupDiscount').textContent = valeur;
        document.getElementById('popupDescription').textContent = description;
        document.getElementById('popupExpiry').textContent = expire_le || 'N/A';

        // Afficher le popup
        document.getElementById('offerPopup').style.display = 'flex';
    }

    // Fonction pour masquer le popup
    function closePopup() {
        document.getElementById('offerPopup').style.display = 'none';
    }

    // Fermer le popup si l'utilisateur clique en dehors du contenu
    window.onclick = function (event) {
        const popup = document.getElementById('offerPopup');
        if (event.target === popup) {
            closePopup();
        }
    };
</script>

</body>
</html>
