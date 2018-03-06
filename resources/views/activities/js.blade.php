<script src="//code.jquery.com/jquery-1.11.1.min.js"></script> 
<script>
	$(document).ready(function() {
        var max_fields      = 2;
        var wrapper         = $("#container2");
        var add_button      = $(".add_form_field1");

        var x = 1;
        $(add_button).click(function(e){
            e.preventDefault();
            if(x < max_fields){
                x++;
                $(wrapper).append("<div><td>Person in charge #2: <font color='red'>*</font><br><select class='form-control select' data-live-search='true' name='personInCharge["+x+"]'><option></option>@foreach($officers as $officer)<option value='{{$officer->officer_id}}'>{{$officer->first_name}} {{$officer->last_name}}</option>@endforeach<button  type='button' class='btn btn-danger pull-right delete btn-xs'>X</button></td></div>"); //add input box
            }
      else
      {
      alert('Cannot add anymore.')
      }
        });

        $(wrapper).on("click",".delete", function(e){
            e.preventDefault(); $(this).parent('div').remove(); x--;
        })
    });
</script>

<script>
	function calcCost() {
	var total = 0;
	var sum = 0;

		$('table tr').each( function() {
		if ( $(this).find('td').length && $(this).find('td input').length ) {
		var cost = parseInt($(this).find('td input').eq(1).val()),
		qty = parseInt($(this).find('td input').eq(2).val());
		$(this).find('.sum').html(cost * qty);
			if (!isNaN(cost) && !isNaN(qty))
			total += cost * qty;
		}
		});
			if (!isNaN(total)) {
			document.getElementById('total_sum').value = total;
		}
	}

	calcCost();

	$('input').on('keyup', function() {
	calcCost();
	});
</script>  

<script>  
  $(document).ready(function(){  
      var i=1;  
      $('#eqt').click(function(){  
           i++;  
           $('#dynamic_field_2').append("<tr id='row2"+i+"'><td>Name<input type='text' name='equipment["+i+"]' class='equipment  form-control' placeholder='Enter Equipment' pattern='^[A-Za-z _]*[A-Za-z][A-Za-z _]*$' required></td><td>Quantity<input type='number' name='quantity["+i+"]'  class='quantity form-control' placeholder='Enter Quantity' required></td>	<td style='padding-top: 28px;'><button type='button' name='remove' id="+i+" class='btn btn-danger btn_remove btn-xs'>X</button></td></tr>");  
      });  
      $(document).on('click', '.btn_remove', function(){  
           var button_id = $(this).attr("id");   
           $('#row2'+button_id+'').remove();  
      });  
 });    
</script>  

<script>  
 $(document).ready(function(){  
      var i=1;  
      $('#add').click(function (){  
           i++;  
          $('#dynamic_field').append("<tr id='row"+i+"'><td>Description <font color='red'>*</font><input type='text' pattern='^[A-Za-z _]*[A-Za-z][A-Za-z _]*$' name='budgetDescription["+i+"]' class='budgetDescription form-control' placeholder='Enter Description' required></td><td>Cost<font color='red'>*</font><input type='number' name='budgetCost["+i+"]'  onkeyup='calcCost()' class=' form-control' placeholder='Enter Cost' required></td> <td>Quantity <font color='red'>*</font><input type='number' name='budgetQuantity["+i+"]'  onkeyup='calcCost()' class='budgetQuantity form-control' placeholder='Enter Qty' required></td><td>Value:<br><span class='sum'></span> </td>  <td style='padding-top: 35px;'><button type='button' name='remove' id="+i+" class='btn btn-danger btn_remove btn-xs'>X</button></td></tr>");
      });  
      $(document).on('click', '.btn_remove', function(){  
           var button_id = $(this).attr("id");   
           $('#row'+button_id+'').remove();  
      });  
 });

</script>

<script>
	function showfield2(name){
	if(name=='6')document.getElementById('div2').innerHTML='<div class="form-group">Other: <input type="text" pattern="^[A-Za-z _]*[A-Za-z][A-Za-z _]*$" name="sourceOfFund" class="form-control" placeholder="Please specify here" > </div>';
	else document.getElementById('div2').innerHTML='';
	}
</script>


<script>

    function yesnoCheck(that) {
        if (that.value == "1") {
            document.getElementById("ifYes").style.display = "block";
        } else {
            document.getElementById("ifYes").style.display = "none";
        }
    }
</script>