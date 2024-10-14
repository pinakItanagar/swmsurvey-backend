<!-- Sidebar scroll-->
<div class="scroll-sidebar">
    <!-- Sidebar navigation-->
    <nav class="sidebar-nav">
        <ul id="sidebarnav" class="p-t-30">


            <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?= base_url("dashboard") ?>" aria-expanded="false"><i class="mdi mdi-view-dashboard"></i><span class="hide-menu">Dashboard</span></a></li>


            <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-map"></i><span class="hide-menu">Medical Colleges</span></a>
                <ul aria-expanded="false" class="collapse  first-level">
                    <li class="sidebar-item">
                        <a href="#" class="sidebar-link">
                            <i class="mdi mdi-note-outline"></i><span class="hide-menu">Govt Colleges</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                      <!--<a href="<? //= base_url('managesurveyor/wardwisesurveyor')  ?>" class="sidebar-link">
                        <i class="mdi mdi-note-outline"></i><span class="hide-menu">Assign Wards</span>
                      </a>-->
                        <a href="#" class="sidebar-link">
                            <i class="mdi mdi-note-outline"></i><span class="hide-menu">Private Colleges</span>
                        </a>
                    </li>
                </ul>
            </li>

           
            <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-office"></i><span class="hide-menu">Stock / Inventory</span></a>
                <ul aria-expanded="false" class="collapse  second-level">
                    <li class="sidebar-item">
                        <a href="#" class="sidebar-link">
                            <i class="mdi mdi-note-outline"></i><span class="hide-menu">Injections</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="#" class="sidebar-link">
                            <i class="mdi mdi-note-outline"></i><span class="hide-menu">Oxygen Supply</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="<?= base_url('managesurveyor/issueregistervendordate') ?>" class="sidebar-link">
                            <i class="mdi mdi-note-outline"></i><span class="hide-menu">Plasma</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="<?= base_url('managesurveyor/qrInstalledVsIssued') ?>" class="sidebar-link">
                            <i class="mdi mdi-google-maps"></i><span class="hide-menu">Vaccines</span>
                        </a>
                    </li>
                </ul>
            </li>
          

           
            
        </ul>
    </nav>
    <!-- End Sidebar navigation -->
</div>
<!-- End Sidebar scroll-->