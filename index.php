<?php include 'modules/api/exchangeratesapi.io.php'; ?>
<!DOCTYPE html>
<html>
<head>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.bundle.js"></script>
  <script type="text/javascript">
    function buyPriceAjax(){
      var xhttp;
        xhttp = new XMLHttpRequest();
        var from = document.getElementById('from').value;
        var to = document.getElementById('to').value;
        var from_amount = document.getElementById('from_amount').value;
        xhttp.onreadystatechange = function() {
        if(this.readyState == 4 && this.status == 200){
            document.getElementById("to_amount").value = this.responseText;
        }
        };
        xhttp.open("GET", "modules/api/exchangeratesapi.io.php?function=0&from="+from+"&to="+to+"&from_amount="+from_amount, true);
        xhttp.send();  
    }

  </script>
  <title></title>
</head>
<body>
<input type="text" id="from_amount" value="1">
<select name="from" id="from">
  <?php currencyList(); ?>
</select>
<br>
<input type="text" id="to_amount" value="1" readonly="">
<select name="to" id="to">
  <?php currencyList(); ?>
</select>
<br>
<button onclick="buyPriceAjax()">Convert</button>
<br>
<hr>



</body>

</html>