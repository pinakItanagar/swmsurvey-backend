<!-- Sidebar scroll-->
<div class="scroll-sidebar">
    <!-- Sidebar navigation-->
    <nav class="sidebar-nav">
        <ul id="sidebarnav" class="p-t-30">


            <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?= base_url("dashboard") ?>" aria-expanded="false"><i class="mdi mdi-view-dashboard"></i><span class="hide-menu">Dashboard</span></a></li>


            <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-map"></i><span class="hide-menu">Surveyors</span></a>
                <ul aria-expanded="false" class="collapse  first-level">
                    <li class="sidebar-item">
                        <a href="<?= base_url('managesurveyor/listing') ?>" class="sidebar-link">
                            <i class="mdi mdi-note-outline"></i><span class="hide-menu">Manage Surveyors</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                      <!--<a href="<? //= base_url('managesurveyor/wardwisesurveyor')  ?>" class="sidebar-link">
                        <i class="mdi mdi-note-outline"></i><span class="hide-menu">Assign Wards</span>
                      </a>-->
                        <a href="<?= base_url('managesurveyor/wardlisting') ?>" class="sidebar-link">
                            <i class="mdi mdi-note-outline"></i><span class="hide-menu">Assign Wards</span>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi  mdi-home-variant"></i><span class="hide-menu">Properties</span></a>
                <ul aria-expanded="false" class="collapse  second-level">
                    <li class="sidebar-item">
                        <a href="<?= base_url('manageproperty/propertyaudit') ?>" class="sidebar-link">
                            <i class="mdi mdi-note-outline"></i><span class="hide-menu">Audit</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="<?= base_url('manageproperty/propertylisting') ?>" class="sidebar-link">
                            <i class="mdi mdi-note-outline"></i><span class="hide-menu">Existinng Properties</span>
                        </a>
                    </li>

                    <li class="sidebar-item">
                        <a href="<?= base_url('managepropertygis/listing') ?>" class="sidebar-link">
                            <i class="mdi mdi-google-maps"></i><span class="hide-menu">Ward wise map</span>
                        </a>
                    </li>

                     <li class="sidebar-item">
                        <a href="<?= base_url('denialcase/viewinfo') ?>" class="sidebar-link">
                            <i class="mdi mdi-alert-octagon"></i><span class="hide-menu">Denial Cases</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-stocking"></i><span class="hide-menu">Stock / Inventory</span></a>
                <ul aria-expanded="false" class="collapse  second-level">
                    <li class="sidebar-item">
                        <a href="<?= base_url('managesurveyor/issueregistervendor') ?>" class="sidebar-link">
                            <i class="mdi mdi-note-outline"></i><span class="hide-menu">Vendor-wise Total QR</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="<?= base_url('managesurveyor/issueregister') ?>" class="sidebar-link">
                            <i class="mdi mdi-note-outline"></i><span class="hide-menu">Surveyor-wise Total QR</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="<?= base_url('managesurveyor/issueregistervendordate') ?>" class="sidebar-link">
                            <i class="mdi mdi-note-outline"></i><span class="hide-menu">Date-wise Total QR</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="<?= base_url('managesurveyor/qrInstalledVsIssued') ?>" class="sidebar-link">
                            <i class="mdi mdi-google-maps"></i><span class="hide-menu">QR Code installed VS Issued</span>
                        </a>
                    </li>
                </ul>
            </li>
            
            <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="<?= base_url("managesurveyor/vendorlisting") ?>" aria-expanded="false"><i class="mdi mdi-office"></i><span class="hide-menu">Vendor List</span></a></li>

            <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-chart-bar"></i><span class="hide-menu">Reports</span></a>
                <ul aria-expanded="false" class="collapse  second-level">
                    <li class="sidebar-item">
                        <!--<a href="<?//= base_url('manageproperty/wardwisesurveyorsurveyed') ?>" class="sidebar-link">
                            <i class="mdi mdi-google-maps"></i><span class="hide-menu">Ward-wise Surveyor Surveyed</span>
                        </a>-->
                        <a href="<?= base_url('manageproperty/surveyorWiseQRInstalled') ?>" class="sidebar-link">
                            <i class="mdi mdi-google-maps"></i><span class="hide-menu">Surveyor QR Code Installed</span>
                        </a>
                    </li>		    
                    <li class="sidebar-item">
                        <a href="<?= base_url('manageproperty/dateWiseQRInstalled') ?>" class="sidebar-link">
                            <i class="mdi mdi-google-maps"></i><span class="hide-menu">Date-wise QR Code Installed</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="<?= base_url('generalreport/allwards') ?>" class="sidebar-link">
                            <i class="mdi mdi-file-excel"></i><span class="hide-menu">Survey Reports</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="<?= base_url('footprintreport/report') ?>" class="sidebar-link">
                            <i class="mdi mdi-book-open"></i><span class="hide-menu">Footprint Report</span>
                        </a>
                    </li>
                    
                     <li class="sidebar-item">
                        <a href="<?= base_url('vehicle/report') ?>" class="sidebar-link">
                            <i class="mdi mdi-truck"></i><span class="hide-menu">Vehicle Data Analysis</span>
                        </a>
                    </li>
		           <li class="sidebar-item">
                        <a href="<?= base_url('generalreport/vendorinvoice') ?>" class="sidebar-link">
                            <i class="mdi mdi-book-open"></i><span class="hide-menu">Vendor Invoice</span>
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="<?= base_url('armsensor/vehicles') ?>" class="sidebar-link">
                            <i class="mdi mdi-book-open"></i><span class="hide-menu">Arm Sensor Report</span>
                        </a>
                    </li>

                    <li class="sidebar-item">
                        <a href="<?= base_url('geocode/area') ?>" class="sidebar-link">
                            <i class="mdi mdi-book-open"></i><span class="hide-menu">Vehicles in My Area</span>
                        </a>
                    </li>
                </ul>
            </li>

              <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-cube-outline"></i><span class="hide-menu">Extras</span></a>

                 <ul aria-expanded="false" class="collapse  second-level">
                    <li class="sidebar-item">
                        <a href="<?= base_url('vehiclesearch/search') ?>" class="sidebar-link">
                            <i class="mdi mdi-map-marker-radius"></i><span class="hide-menu">Vehicle Search</span>
                        </a>
                    </li>           
                </ul>

              </li>  
            
        </ul>
    </nav>
    <!-- End Sidebar navigation -->
</div>
<!-- End Sidebar scroll-->