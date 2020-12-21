<html>
 <head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Laravel 5.8 - Daterange Filter in Datatables with Server-side Processing</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>  
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.js"></script>
 </head>
 <body>
  <div class="container">    
     <br />
     <br />
            <br />
            <div class="row input-daterange">
                <div class="col-md-4">
                    <input type="text" name="from_price" id="from_price" class="form-control" placeholder="From Price" />
                </div>
                <div class="col-md-4">
                    <input type="text" name="to_price" id="to_price" class="form-control" placeholder="To Price" />
                </div>
                <div class="col-md-4">
                    <button type="button" name="filter" id="filter" class="btn btn-primary">Filter</button>
                    <button type="button" name="refresh" id="refresh" class="btn btn-default">Refresh</button>
                </div>
            </div>
            <br />
   <div class="table-responsive">
    <table class="table table-bordered table-striped" id="product">
           <thead>
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Price</th>
                <th>Type</th>
                <th>Is_active</th>
            </tr>
           </thead>
       </table>
   </div>
  </div>
 </body>
</html>

<script>
$(document).ready(function(){
//  $('.input-daterange').datepicker({
//   todayBtn:'linked',
//   format:'yyyy-mm-dd',
//   autoclose:true
//  });

//  load_data();

 function load_data(from_price = '', to_price = '')
 {
  $('#product').DataTable({
   processing: true,
   serverSide: true,
   ajax: {
    url:'{{ route("product.index") }}',
    data:{from_price:from_price, to_price:to_price}
   },
   columns: [
    {
     data:'id',
     name:'id'
    },
    {
     data:'title',
     name:'title'
    },
    {
     data:'description',
     name:'description'
    },
    {
     data:'price',
     name:'price'
    },
    {
     data:'type',
     name:'type'
    },
    {
     data:'is_active',
     name:'is_active'
    }
   ]
  });
 }

 $('#filter').click(function(){
  var from_price = $('#from_price').val();
  var to_price = $('#to_price').val();
  if(from_price != '' &&  to_price != '')
  {
   $('#product').DataTable().destroy();
   load_data(from_price, to_price);
  }
  else
  {
   alert('Both prices are required');
  }
 });

 $('#refresh').click(function(){
  $('#from_price').val('');
  $('#to_price').val('');
  $('#product').DataTable().destroy();
  load_data();
 });

});
</script>