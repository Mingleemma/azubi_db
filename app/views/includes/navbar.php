<div class="navbar navbar-inverse navbar-fixed-top bg-indigo">
   <div class="navbar-header">
      <a class="navbar-brand" href="index.html"><span style="font-weight:bold; font-size:16px"> LFB DATENBANK  <span></a>
      <ul class="nav navbar-nav visible-xs-block">
         <li><a data-toggle="collapse" data-target="#navbar-mobile"><i class="icon-tree5"></i></a></li>
         <li><a class="sidebar-mobile-main-toggle"><i class="icon-paragraph-justify3"></i></a></li>
      </ul>
   </div>
   <div class="navbar-collapse collapse" id="navbar-mobile">
      <ul class="nav navbar-nav">
         <li><a class="sidebar-control sidebar-main-toggle hidden-xs"><i class="icon-paragraph-justify3"></i></a></li>
      </ul>

       <div class="navbar-right">
           <a href="/ldb/data/logout/"> <p class="navbar-text"><span class="label bg-success-400">logout</span></p></a>

       </div>

   </div>


</div>
<script type="text/javascript">
    var leherehead = {
        <?php
        /*
         * PHP 7 throws warnings about non-scalar values in constants...
         * serialized JSVARS to compensate.
        */
        foreach (unserialize(JSVARS) as $jskey => $jsval){
            echo $jskey . " : '" . $jsval . "',";
        }
        ?>
    }
</script>