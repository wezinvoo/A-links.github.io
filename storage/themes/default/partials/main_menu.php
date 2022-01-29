<ul class="navbar-nav ml-lg-auto">
    <li class="nav-item nav-item-spaced d-lg-block">
        <a class="nav-link" href="<?php echo route('home') ?>"><?php ee('Home') ?></a>
    </li>    
    <?php if(config('pro')): ?>
    <li class="nav-item nav-item-spaced d-lg-block">
        <a class="nav-link" href="<?php echo route('pricing') ?>"><?php ee('Pricing') ?></a>
    </li>   
    <?php endif ?>
    <li class="nav-item nav-item-spaced dropdown dropdown-animate" data-toggle="hover">
        <a class="nav-link" data-toggle="dropdown" href="#" aria-haspopup="true" aria-expanded="false"><?php ee('Solutions') ?></a>
        <div class="dropdown-menu dropdown-menu-xl p-0">
            <div class="row no-gutters">
                <div class="col-12 col-lg-6 order-lg-2">
                    <div class="dropdown-body dropdown-body-right bg-dropdown-secondary h-100"> 
                        <h6 class="dropdown-header">
                            <?php ee('Resources') ?>
                        </h6>
                        <?php if(config('api')): ?>
                            <div class="list-group list-group-flush">
                                <div class="list-group-item bg-transparent border-0 px-0 py-2">
                                    <div class="media d-flex">                                    
                                        <span class="h6">
                                            <i data-feather="code"></i>
                                        </span>                                    
                                        <div class="media-body ml-2">
                                            <a href="<?php echo route('apidocs') ?>" class="d-block h6 mb-0"><?php ee('Developer API') ?></a>
                                            <small class="text-sm text-muted mb-0"><?php ee('Guide on how to use our API') ?></small>
                                        </div>
                                    </div>
                                </div>                            
                            </div>
                        <?php endif ?>
                        <div class="list-group list-group-flush">
                            <div class="list-group-item bg-transparent border-0 px-0 py-2">
                                <div class="media d-flex">                                    
                                    <span class="h6">
                                        <i data-feather="help-circle"></i>
                                    </span>                                    
                                    <div class="media-body ml-2">
                                        <a href="<?php echo route('faq') ?>" class="d-block h6 mb-0"><?php ee('Help') ?></a>
                                        <small class="text-sm text-muted mb-0"><?php ee('Check out our frequently asked questions') ?></small>
                                    </div>
                                </div>
                            </div>                            
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-6 order-lg-1 mt-4 mt-lg-0">
                    <div class="dropdown-body">
                        <h6 class="dropdown-header">
                            <?php ee('Solutions') ?>
                        </h6>
                        <div class="list-group list-group-flush">
                            <div class="list-group-item border-0">
                                <div class="media d-flex">                                    
                                    <div class="media-body">
                                        <a href="<?php echo route('page.qr') ?>" class="d-block h6 mb-0"><?php ee('QR Codes') ?></a>
                                        <small class="text-sm text-muted mb-0"><?php ee('Customizable & trackable QR codes') ?></small>
                                    </div>
                                </div>
                            </div> 
                            <div class="list-group-item border-0">
                                <div class="media d-flex">                                    
                                    <div class="media-body">
                                        <a href="<?php echo route('page.bio') ?>" class="d-block h6 mb-0"><?php ee('Bio Profiles') ?></a>
                                        <small class="text-sm text-muted mb-0"><?php ee('Convert your social media followers') ?></small>
                                    </div>
                                </div>
                            </div>                              
                            <?php foreach(\Helpers\App::pages('main') as $page): ?>
                                <div class="list-group-item border-0">
                                    <div class="media d-flex">                                    
                                        <div class="media-body">
                                            <a href="<?php echo route('page', [$page->seo]) ?>" class="d-block h6 mb-0"><?php ee($page->name) ?></a>
                                        </div>
                                    </div>
                                </div>                                 
                            <?php endforeach ?>                                                        
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </li>
    <?php if(config('blog')): ?>
    <li class="nav-item nav-item-spaced d-lg-block">
        <a class="nav-link" href="<?php echo route('blog') ?>"><?php ee('Blog') ?></a>
    </li>
    <?php endif ?>
    <?php plug('homemenu') ?>
</ul>
<ul class="navbar-nav align-items-lg-center d-none d-lg-flex ml-lg-auto">
    <li class="nav-item">
        <?php if(\Core\Auth::logged()): ?>
            <?php if(\Core\Auth::user()->admin): ?>
                <a class="nav-link" href="<?php echo route('admin') ?>"><?php ee('Admin Panel') ?></a>
            <?php endif ?>
        <?php else: ?>
            <a class="nav-link" href="<?php echo route('login') ?>"><?php ee('Login') ?></a>
        <?php endif ?>
    </li>
    <li class="nav-item">
        <?php if(\Core\Auth::logged()): ?>
            <a href="<?php echo route('dashboard') ?>" class="btn btn-sm btn-success btn-icon ml-3">
                <span class="btn-inner--icon"><i data-feather="user"></i></span>
                <span class="btn-inner--text"><?php ee('Dashboard') ?></span>
            </a>
        <?php else: ?>
            <?php if(config("user") && !config("private") && !config("maintenance")): ?>
                <a href="<?php echo route('register') ?>" class="btn btn-sm btn-success btn-icon ml-3">
                    <span class="btn-inner--text"><?php ee('Get Started') ?></span>
                </a>
            <?php endif ?>
        <?php endif ?>
    </li>
</ul>
<?php if(config("user") && !config("private") && !config("maintenance")): ?>
    <div class="d-lg-none px-4 text-center">    
        <?php if(\Core\Auth::logged()): ?>
            <a href="<?php echo route('dashboard') ?>" class="btn btn-block btn-sm btn-success"><?php ee('Dashboard') ?></a>
        <?php else: ?>
            <div class="d-flex">
                <div class="w-50 mr-1">
                    <a href="<?php echo route('login') ?>" class="btn btn-block btn-sm btn-primary"><?php ee('Login') ?></a>
                </div>
            <?php if(config("user") && !config("private") && !config("maintenance")): ?>
                <div class="w-50 ml-1">
                    <a href="<?php echo route('register') ?>" class="btn btn-block btn-sm btn-primary"><?php ee('Get Started') ?></a>
                </div>
            <?php endif ?> 
            </div>               
        <?php endif ?>          
    </div>    
<?php endif ?>