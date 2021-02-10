<script type="text/javascript">
        var fdacfg = {
            <?php
                /*
                 * PHP 7 throws warnings about non-scalar values in constants...
                 * serialized JSVARS to compensate.
                */
                foreach (unserialize(JSVARS) as $jskey => $jsval) {
                    echo $jskey . " : '" . $jsval . "',";
                }
            ?>
        }
    </script>

<header class="topbar-nav">
 <nav class="navbar navbar-expand fixed-top bg-white">
  <ul class="navbar-nav mr-auto align-items-center">
    <li class="nav-item">
      <a class="nav-link toggle-menu" href="javascript:void();">
       <i class="icon-menu menu-icon"></i>
     </a>
    </li>
    <li class="nav-item">
      <form class="search-bar">
        <input type="text" class="form-control" placeholder="Enter keywords">
         <a href="javascript:void();"><i class="icon-magnifier"></i></a>
      </form>
    </li>
  </ul>
     
  <ul class="navbar-nav align-items-center right-nav-link">
      <li> <i class="icon-power"></i> <a href='<?php echo URLROOT.'/pages/logout'  ?>'>Logout</a></li>
  </ul>
</nav>
</header>