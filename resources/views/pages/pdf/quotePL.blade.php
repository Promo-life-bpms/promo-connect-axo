<!DOCTYPE html>
<html lang="en">

<head>
    <title>Cotizacion PL</title>
    <link rel="stylesheet" href="quotesheet/bh/stylebh.css">
</head>

<body>
    <style>
      
        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        } 

        th{
            background-color: black;
            color: white;
            text-align: center;
            font-size: 17px;
            font-weight: bold;
            border-color: #006EAD;
        }
        
    </style>
    <header>
        {{-- <img src="quotesheet/bh/triangulos.png" alt="" srcset="" class="fondo-head"> --}}
        
        <table style=" margin-bottom:16px;">
            <tr>
                <td style="width: 50%;">
                    <div style="display:flex; margin-top:10px; margin-left: 30px;">
                        <img src="img/promolife.png" style="width: 100px;" >
                    </div>
                    <p style="margin-left:30px; margin-top:10px; "><b>Promo life S. de R.L. de C.V. S.A.</b> </p>
                    <p style="margin-left:30px;">San Andrés Atoto 155A Naucalpan de Juárez, Méx. C.P. 53550 Tel. +52(55) 5290 9100</p>
                </td>
                
                <td style="text-align: left; width: 50%;">
                    <div style="margin-left:60px; display:flex; margin-top:30px;">
                        <img src="img/axo-black.png" style="width:100px;" >
                    </div>

                    <p style="margin-left:60px; margin-top:50px;">Fecha: <b>{{$date}}</b></p>
                    <p style="margin-left:60px;"></p>
                </td>
            </tr>
        </table>
    </header>

    <footer>
        <table class="footer content">
            <tr>
                <td colspan="3">
                    <center style="font-size: 20px; margin-bottom:5px;"><b>www.promolife.mx</b></center>
                
                <center style="font-size:12px;">San Andrés Atoto 155A Naucalpan de
                    Juárez, Méx. C.P. 53550
                    Tel. +52(55) 6269 0017 </center>
            </td>
            </tr>
            
        </table>
        <div style="text-align: right">
            <p class="content">Pagina <span class="pagenum"></span></p>
        </div>
    </footer>
    
    <div style="margin-left:30px; margin-right:30px; margin-top:8px;">
        
        <div style="width: 100%; height:1px; background-color:black; margin-top:8px; "></div>
        
        @foreach($quotes as $quote)
           @php
                try {
                    if ($quote->logo != null) {
                        $logo = public_path('/storage/logos/' . $quote->logo);
                        $image64 = base64_encode(file_get_contents($logo));
                    } else {
                        $logo = public_path('img/default.jpg');
                        $image64 = base64_encode(file_get_contents($logo));
                    }
                } catch (\Exception $e) {
                    $logo = public_path('img/default.jpg');
                    $image64 = base64_encode(file_get_contents($logo));
                }

                $quoteTechnique = \App\Models\QuoteTechniques::where('quotes_id',$quote->id)->get()->last();

                $product = \App\Models\QuoteProducts::where('id', $quote->id)->get()->last();
                $productData = json_decode($product->product);

                $productName = isset($productData->name) ? $productData->name : 'Nombre no disponible';
                
                    
                @endphp

                <br>
                <p style="margin-left:60px;">Cotizacion: <b>SQ-{{ $quote->id }}</b></p>
               
                <table border="1" >
                    <tr>
                        <th style="width:30%" >Imagen de Referencia</th>
                        <th style="width:70%" colspan="3">Descripción </th>
                    </tr>
                    <tr>
                        <td rowspan="6" style="width:30%"> 
                            <center><img style="width:200px;  object-fit:contain;" src="data:image/png;base64,{{$image64}}" alt=""></center>
                        </td>
                        <td colspan="3" style="width:70%; padding:2px;">{{ $productName }}</td>
                        
                    </tr>
                    <tr>
                        <th colspan="1" style="width:35%; padding:2px;">Tecnica de Personalizacion </th>
                        <th colspan="2" style="width:35%; padding:2px;" >Detalle de la Personalizacion </th>
                    </tr>
                    <tr>
                        <td colspan="1" style="width:35%">{{ isset($quote->currentQuotesTechniques->technique)? $quote->currentQuotesTechniques->technique :  '' }} </td>
                        <td colspan="2" style="width:35%">
                            <p> <b>Material: </b>  {{ isset($quoteTechnique->material)? $quoteTechnique->material : ''  }} </p>
                            <p> <b>Tamaño: </b>  {{ isset($quoteTechnique->size)? $quoteTechnique->size : '' }} </p>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" style="width:10% ;"><center><b>Tiempo de Entrega: 15 días hábiles</b> </center>  </td>
                    </tr>
                    <tr>
                        <th colspan="1">Cantidad</th>
                        <th colspan="1">Precio Unitario</th>
                        <th colspan="1">Precio total</th>
                    </tr>
                    <tr>
                        <td colspan="1"> {{ $product->cantidad}} piezas</td>
                        <td colspan="1"> {{ $product->precio_unitario}} </td>
                        <td colspan="1"> {{ $product->precio_total}}</td>
                    </tr>
                </table>
            <br>
        @endforeach
              
                
          
           
    </div>

    <div style="margin-left:30px;">
        <p> Condiciones:</p>
        <ul>
            <li>Condiciones de pago acordadas en el contrato</li>
            <li>Precios unitarios mostrados antes de IVA</li>
            <li>Precios mostrados en pesos mexicanos (MXP)</li>
        </ul>
    </div>

</body>

</html>
