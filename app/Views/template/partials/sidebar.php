<!--begin::Sidebar-->
<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <!--begin::Sidebar Brand-->
    <div class="sidebar-brand">
        <!--begin::Brand Link-->
        <a href="./index.html" class="brand-link">
            <!--begin::Brand Image-->
            <img
                src="<?= base_url('dist/assets/img/shoei-logo-pequeno.png') ?>"
                alt="Shoei"
                class="brand-image opacity-75 shadow" />
            <!--end::Brand Image-->
            <!--begin::Brand Text-->
            <span class="brand-text fw-light">Shoei</span>
            <!--end::Brand Text-->
        </a>
        <!--end::Brand Link-->
    </div>
    <!--end::Sidebar Brand-->
    <!--begin::Sidebar Search-->
    <div class="sidebar-search" role="search">
        <label for="sidebar-search-input" class="visually-hidden">Filtrar menú</label>
        <input
            type="search"
            id="sidebar-search-input"
            class="form-control form-control-sm"
            placeholder="Filtrar menú…"
            autocomplete="off"
            data-lte-toggle="sidebar-search"
            data-lte-target="#navigation" />
        <p class="fs-7 text-secondary mt-2 mb-0" data-lte-search-empty role="status" hidden>
            No hay resultados.
        </p>
    </div>
    <!--end::Sidebar Search-->
    <!--begin::Sidebar Wrapper-->
    <div class="sidebar-wrapper">
        <nav class="mt-2" aria-label="Main navigation">
            <!--begin::Sidebar Menu-->
            <ul
                class="nav sidebar-menu flex-column"
                data-lte-toggle="treeview"
                data-accordion="false"
                id="navigation">
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon bi bi-speedometer"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="./starter.html" class="nav-link">
                        <i class="nav-icon bi bi-people"></i>
                        <p>Usuarios</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon bi bi-ticket"></i>
                        <p>
                            Tickets
                            <span class="nav-badge badge text-bg-secondary me-3">12</span>
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="./layout/unfixed-sidebar.html" class="nav-link">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Mis Tickets</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="./layout/fixed-sidebar.html" class="nav-link">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Todos</p>
                            </a>
                        </li>                        
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon bi bi-graph-up"></i>
                        <p>
                            Reportes
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="./UI/general.html" class="nav-link">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Análisis</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="./UI/icons.html" class="nav-link">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>SLA</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="./UI/timeline.html" class="nav-link">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Calificaciones</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon bi bi-gear"></i>
                        <p>
                            Configuración
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="./mailbox/inbox.html" class="nav-link">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Equipo</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="./mailbox/read.html" class="nav-link">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Politicas SLA</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="./mailbox/compose.html" class="nav-link">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Mensajes</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
            <!--end::Sidebar Menu-->

            <!-- Docs CTA (bottom of sidebar) -->
            <div class="p-3 mt-3 border-top border-secondary border-opacity-25">
                <a
                    href="./docs/introduction.html"
                    class="btn btn-sm btn-outline-light w-100 d-flex align-items-center justify-content-center gap-2">
                    <i class="bi bi-book" aria-hidden="true"></i>
                    Documentación
                </a>
            </div>
        </nav>
    </div>
    <!--end::Sidebar Wrapper-->
</aside>
<!--end::Sidebar-->