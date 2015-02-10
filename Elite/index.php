<?php
  $xml_file = 'goods-econ.xml';
  if (file_exists($xml_file)) $xml = simplexml_load_file($xml_file);
  else die('Failed to open '.$xml_file);

  $arr = json_decode(json_encode($xml),true);
?>
<html>
  <head>
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css" >
    <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
    <script type="text/javascript">
      $(document).ready(function() {

        $("#filter_name").keyup(function() {
          //hide all the rows
          $("tbody").find("tr").hide();
          
          //split the current value of searchInput
          var data = this.value.split(" ");
          //create a jquery object of the rows
          var obj = $("tbody").find("tr");
          
          //Recursively filter the jquery object to get results.
          $.each(data, function(i, v) {
            obj = obj.filter(function() {
              return $(this).text().toLowerCase().indexOf(v.toLowerCase()) > -1;
            });
          });
          
          //show the rows that match.
          obj.show();
        });

        $("#filter_buy").change(function() {
          econ = '.'+$(this).val();
          $(econ+'.buy-inactive').parent().parent().hide();
        });

        $("#filter_sell").change(function() {
          econ = '.'+$(this).val();
          $(econ+'.sell-inactive').parent().parent().hide();
        });

         $("#reset").click(function() {
          $("tr").show();
          $('#filter_name').val('');
          $('#filter_buy').prop('selectedIndex',0);
          $('#filter_sell').prop('selectedIndex',0);
        });

        $(".ext[class$=-active]").tooltip({title:'Extraction'});   
        $(".ref[class$=-active]").tooltip({title:'Refinery'});   
        $(".agr[class$=-active]").tooltip({title:'Agriculture'});   
        $(".ind[class$=-active]").tooltip({title:'Industrial'});   
        $(".hig[class$=-active]").tooltip({title:'High Tech'}); 
        
      });
    </script>

    <style>
      .buy {
        display: inline-block;
        margin: 0 5px;
        padding: 5px;
        height: 54px;
        width: 54px;
      }

      .buy-active {
        border: 1px solid;
        border-radius: 3px;
      }

      .buy-inactive {
        border: 1px solid;
        border-radius: 3px;
        opacity: 0.25;
      }

      .sell {
        display: inline-block;
        padding: 5px;
        height: 54px;
        width: 54px;
      }

      .sell-active {
        border: 1px solid;
        border-radius: 27px;
      }

      .sell-inactive {
        border: 1px solid;
        border-radius: 27px;
        opacity: 0.25;
      }
    </style>
  </head>
  <body>
    <!-- Fixed navbar -->
    <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="row">
          <div class="col-sm-10">
            <h1>Elite Dangerous <small>Goods-by-Economy Trading Tool</small></h1>
          </div>
          <div class="col-sm-2 text-right">
            <br/><br/>
            <button id="reset" type="button" class="btn btn-default">Reset Filters</button>
          </div>                    
        </div>
        <div class="row">
          <div class="col-sm-4">
            <div class="form-group">
              <label for="filter_name">Name</label><br/>
              <input id="filter_name"  type="text" class="form-control" placeholder="Filter Name"></input>
            </div>           
          </div> <!-- .col -->
          <div class="col-sm-4">
            <div class="form-group">
              <label for="filter_buy">Buy From</label><br/>
              <select id="filter_buy" class="form-control">
                <option selected disabled>Filter Buy Economy</option>
                <option value="ext">Extraction</option>
                <option value="ref">Refinery</option>
                <option value="agr">Agriculture</option>
                <option value="ind">Industrial</option>
                <option value="hig">High Tech</option>
              </select>
            </div>           
          </div> <!-- .col -->
          <div class="col-sm-4">
            <div class="form-group">
              <label for="filter_sell">Sell To</label><br/>
              <select id="filter_sell" class="form-control">
                <option selected disabled>Filter Sell Economy</option>
                <option value="ext">Extraction</option>
                <option value="ref">Refinery</option>
                <option value="agr">Agriculture</option>
                <option value="ind">Industrial</option>
                <option value="hig">High Tech</option>
              </select>
            </div>           
          </div> <!-- .col -->
        </div> <!-- .row -->
      </div> <!-- .container -->
    </nav>  
    <div class="container" style="margin-top: 150px;">
      <div class="row">
        <div class="col-sm-12">
          <table class="table">
            <thead>
              <tr>
                <th>Name</th>
                <th>Buy From</th>
                <th>Sell To</th>
              <tr>
            </thead>
            <tbody>
            <?php
              foreach($arr[commodities][good] as $good) {

                $category = strtolower(str_replace(' ','',$good['category']));

                // Fix JSON encode/decode single/array object
                if(!is_array($good[buyfrom][economy])) {
                  $good[buyfrom][economy] = array($good[buyfrom][economy]);
                }
                
                $ext_buy = (in_array('Extraction',  $good[buyfrom][economy]) ? 'buy-active' : 'buy-inactive');
                $ref_buy = (in_array('Refinery',    $good[buyfrom][economy]) ? 'buy-active' : 'buy-inactive');
                $agr_buy = (in_array('Agriculture', $good[buyfrom][economy]) ? 'buy-active' : 'buy-inactive');
                $ind_buy = (in_array('Industrial',  $good[buyfrom][economy]) ? 'buy-active' : 'buy-inactive');
                $hig_buy = (in_array('High Tech',   $good[buyfrom][economy]) ? 'buy-active' : 'buy-inactive');                                    

                // Fix JSON encode/decode single/array object
                if(!is_array($good[sellto][economy])) {
                  $good[sellto][economy] = array($good[sellto][economy]);
                }                
                
                $ext_sel = (in_array('Extraction',  $good[sellto][economy]) ? 'sell-active' : 'sell-inactive');
                $ref_sel = (in_array('Refinery',    $good[sellto][economy]) ? 'sell-active' : 'sell-inactive');
                $agr_sel = (in_array('Agriculture', $good[sellto][economy]) ? 'sell-active' : 'sell-inactive');
                $ind_sel = (in_array('Industrial',  $good[sellto][economy]) ? 'sell-active' : 'sell-inactive');
                $hig_sel = (in_array('High Tech',   $good[sellto][economy]) ? 'sell-active' : 'sell-inactive');  
            ?>
              <tr>
                <td class="col-sm-4">
                  <?php echo $good['name']; ?>
                </td>
                <td class="col-sm-4">
                  <div class="buy ext <?php echo $category.' '.$ext_buy; ?>"><img src="https://d30y9cdsu7xlg0.cloudfront.net/png/13384-42.png"></div>
                  <div class="buy ref <?php echo $category.' '.$ref_buy; ?>"><img src="https://d30y9cdsu7xlg0.cloudfront.net/png/13470-42.png"></div>
                  <div class="buy agr <?php echo $category.' '.$agr_buy; ?>"><img src="https://d30y9cdsu7xlg0.cloudfront.net/png/4221-42.png"></div>
                  <div class="buy ind <?php echo $category.' '.$ind_buy; ?>"><img src="https://d30y9cdsu7xlg0.cloudfront.net/png/13386-42.png"></div>              
                  <div class="buy hig <?php echo $category.' '.$hig_buy; ?>"><img src="https://d30y9cdsu7xlg0.cloudfront.net/png/66252-42.png"></div>
                </td>
                <td class="col-sm-4">
                  <div class="sell ext <?php echo $category.' '.$ext_sel; ?>"><img src="https://d30y9cdsu7xlg0.cloudfront.net/png/13384-42.png"></div>
                  <div class="sell ref <?php echo $category.' '.$ref_sel; ?>"><img src="https://d30y9cdsu7xlg0.cloudfront.net/png/13470-42.png"></div>
                  <div class="sell agr <?php echo $category.' '.$agr_sel; ?>"><img src="https://d30y9cdsu7xlg0.cloudfront.net/png/4221-42.png"></div>
                  <div class="sell ind <?php echo $category.' '.$ind_sel; ?>"><img src="https://d30y9cdsu7xlg0.cloudfront.net/png/13386-42.png"></div>
                  <div class="sell hig <?php echo $category.' '.$hig_sel; ?>"><img src="https://d30y9cdsu7xlg0.cloudfront.net/png/66252-42.png"></div>
                </td>
              </tr>
            <?php
              } // foreach good
            ?>
            </tbody>
          </table>        
        </div>
      </div>
      <div class="row">
        <div class="col-sm-12">
          <h2>Credits</h2>
        </div>
      </div>      
      <div class="row">
        <div class="col-sm-4">
          Icons: <a href="http://thenounproject.com/">Noun Project</a>
          <ul>
            <li>Coal-Trolley by David Chapman</li>
            <li>Bricks by Jon Testa</li>
            <li>Factory by David Chapman</li>
            <li>Agriculture by OCHA Visual Information Unit</li>
            <li>Circuit by Rohith M S</li>
          </ul>
        </div>
       <div class="col-sm-4">Data & Design
         <ul>
           <li><a href="http://redd.it/2ncfa2">CMDR Prometheus Darko</a></li>
           <li><a href="http://redd.it/2nfp27">CMDR WarpSpiderX</a></li>
           <li><a href="http://redd.it/2ottgy">CMDR NeonDevil</a></li>
         </ul>
       </div>
       <div class="col-sm-4">Source
         <ul>
           <li><a href="http://runnable.com/VIe50hSB8S82NFtF">runnable.com</a></li>
         </ul>
       </div>       
      </div>
    </div>
  </body>
</html>