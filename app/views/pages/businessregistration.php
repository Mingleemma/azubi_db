<?php  require ("includes/customernav.php"); ?>
<?php  require ("includes/header.php"); ?>

<div class="clearfix"></div>
<div class="content-wrapper">
    <div class="container-fluid">
    <!-- Breadcrumb-->
     <div class="row pt-2 pb-2">
        <div class="col-sm-9">
        <h4 class="page-title"><span style="color: #FEC70C">
        BUSINESS </span> REGISTRATION </h4>
        
     </div>
     
     </div>
     </div>
    <!-- End Breadcrumb-->
  
     <div class="row pt-2 pb-2">
      <div class="col-lg-12">
        
         <div class="card">
           <div class="card-body">
           <div class="card-title"><span style="color: #0069D9">Please provide business / establishment  information </span> </div>
           <hr>
            <form method='post'>
           <div class="form-group row">
            <label for="input-4" class="col-sm-2 col-form-label">Business Name</label>
            <div class="col-sm-10">
            <input type="text" class="form-control" name='businessname' id="businessname" placeholder="Enter your business name / establish name" required>
            </div>
          </div>


           <div class="form-group row">
            <label for="input-4" class="col-sm-2 col-form-label">Type of Entity</label>
            <div class="col-sm-10">
            <select class="form-control" name="businesstype" id="businesstype" >
             <option value=''>Select Entity Type</option>
             <option>Sole Proprietor</option>
             <option>Partnership</option>
             <option>Corporation</option>
            </select>
            </div>
           </div>

            <div class="form-group row">
            <label for="input-4" class="col-sm-2 col-form-label">Business Reg. No:</label>
            <div class="col-sm-10">
            <input type="text" class="form-control" name="regnumber" id="regnumber" placeholder="Business Registration Number">
            </div>
           </div>

         

          <div class="form-group row">
            <label for="input-5" class="col-sm-2 col-form-label">Telephone</label>
            <div class="col-sm-10">
            <input type="text" class="form-control" name="telephone"  id="telephone" placeholder="Telephone" >
            </div>
          </div>

          <div class="form-group row">
            <label for="input-5" class="col-sm-2 col-form-label">Email</label>
            <div class="col-sm-10">
            <input type="email" class="form-control" name="email"  id="email" placeholder="Email Address" >
            </div>
          </div>

           <div class="form-group row">
            <label for="input-5" class="col-sm-2 col-form-label">Fax</label>
            <div class="col-sm-10">
            <input type="text" class="form-control" name="fax"  id="fax" placeholder="Fax">
            </div>
          </div>

          <div class="form-group row">
            <label for="input-5" class="col-sm-2 col-form-label">Postal Address</label>
            <div class="col-sm-10">
            <input type="text" class="form-control" name="postaladdress"  id="postaladdress" placeholder="Postal address">
            </div>
          </div>

           <div class="form-group row">
            <label for="input-5" class="col-sm-2 col-form-label">Digital Address</label>
            <div class="col-sm-10">
            <input type="text" class="form-control" name="digitaladdress"  id="digitaladdress" placeholder="Digital address">
            </div>
          </div>

          <div class="form-group row">
            <label for="input-5" class="col-sm-2 col-form-label">City</label>
            <div class="col-sm-10">
            <input type="text" class="form-control" name="city"  id="city" placeholder="City">
            </div>
          </div>

           <div class="form-group row">
            <label for="input-5" class="col-sm-2 col-form-label">Region</label>
            <div class="col-sm-10">
            <input type="text" class="form-control" name="region"  id="region" placeholder="Region">
            </div>
          </div>



          <div class="form-group row">
            <label for="input-5" class="col-sm-2 col-form-label">Contact Person</label>
            <div class="col-sm-10">
            <input type="text" class="form-control" name="contactname"  id="contactname" placeholder="Name of contact person">
            </div>
          </div>

          <div class="form-group row">
            <label for="input-5" class="col-sm-2 col-form-label">Contact's Telephone</label>
            <div class="col-sm-10">
            <input type="text" class="form-control" name="contacttelephone"  id="contacttelephone" placeholder="Telephone of contact person">
            </div>
          </div>

          <div class="form-group row">
            <label for="input-5" class="col-sm-2 col-form-label">Contact's Position</label>
            <div class="col-sm-10">
            <input type="text" class="form-control" name="contactposition"  id="contactposition" placeholder="Postion of contact person">
            </div>
          </div>

          
           <div class="form-group row">
            <label for="input-1" class="col-sm-2 col-form-label"></label>
            <div class="col-sm-10">
              <input type="hidden" value="<?php echo $data ?>" name='uid' id='euid' />
            <button type="submit" class="btn btn-primary shadow-primary px-5"><i class="icon-next"></i> Continue</button>
            </div>
          </div>
          </form>
         </div>
         </div>
       
         </div>
      </div>
      </div><!--End Row-->

    </div>

    </div>
    <!-- End container-fluid-->
    
   </div><!--End content-wrapper-->




<?php  require ("includes/footer.php"); ?>
