<style>
    :root {
        --bg-gradient-start: #1e1e2f;
        --bg-gradient-end: #121212;
        --card-bg: #1a1a26;
        --border-color: #2e2e3e;
        --text-color: #e0e0e0;
        --active-link: #0d6efd;
    }

    body {
        background: linear-gradient(to bottom right, var(--bg-gradient-start), var(--bg-gradient-end));
        color: var(--text-color);
        min-height: 100vh;
    }

    .navbar {
        background-color: #1a1a26 !important;
        border-bottom: 1px solid var(--border-color);
    }

    .navbar-brand,
    .nav-link,
    .navbar-text {
        color: var(--text-color) !important;
    }

    .nav-link.active {
        background-color: var(--active-link);
        border-radius: 0.375rem;
        color: #fff !important;
    }

    .card {
        background-color: var(--card-bg);
        border: 1px solid var(--border-color);
    }

    .card-title {
        color: #aaa;
    }

    .text-primary {
        color: #4dabf7 !important;
    }

    .text-success {
        color: #51cf66 !important;
    }

    .text-warning {
        color: #fcc419 !important;
    }

</style>

<style>
/* Ubah teks select (yang terlihat sebelum klik) */
.select2-container--bootstrap4 .select2-selection__rendered {
    color: #000 !important;
}

/* Ubah teks pada option dalam dropdown */
.select2-container--bootstrap4 .select2-results__option {
    color: #000 !important;
}

/* Pastikan placeholder juga hitam */
.select2-container--bootstrap4 .select2-selection__placeholder {
    color: #000 !important;
}
</style>

