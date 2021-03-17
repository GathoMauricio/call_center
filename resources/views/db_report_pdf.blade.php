<html>
<head>
    <style>
        @page {
            margin: 0cm 0cm;
            font-family: Arial;
        }

        body {
            margin: 3cm 2cm 2cm;
        }
        header {
            position: fixed;
            top: 0.5cm;
            left: 0.5cm;
            right: 0.5cm;
            height: 0.5cm;
        }

        footer {
            position: fixed;
            bottom: 0cm;
            left: 0cm;
            right: 0cm;
            height: 2cm;
            background-color: #d30035;
            color:white;
            text-align: left;
            line-height: 15px;
            padding:5px;
        }
    </style>
</head>
<body>
<h3><center>Resultado de la actualización de saldos:<br/>{{ $date }}</center></h3>
<main><br/><br/><br>
<br/><br/><br>
<table style="width:100%;">
<tr><th colspan="3" style="text-align:center;background-color:#D5D8DC;">Etiquetas</th></tr>
@php
$msgs = \App\Account::distinct()->where('created_at','LIKE','%'.$date.'%')->get('message');
$stickersCount = 0;
$lowAmount = 0;
$processable = 0;
foreach($msgs as $msg) { 
    if(!empty($msg->message))
    {
        echo "<tr style='background-color:#D5D8DC;'>";
        echo "<td>".$msg->message."</td>";
        $count=count(\App\Account::where('message',$msg->message)->get());
        $stickersCount+=$count;
        echo "<td>".$count."</td>";
        echo "<td>".number_format(($count * 100) / $total,1)."%</td>";
        echo "</tr>";
    }
}
$accounts = \App\Account::where('message','')->where('created_at','LIKE','%'.$date.'%')->get();
foreach($accounts as $account)
{
    $amount = str_replace(['$',',',' '], '', $account->amount);
    if(floatval($amount < 800))
    {
        $lowAmount++;
    }else{
        $processable++;
    }
}
echo "<tr style='background-color:#D5D8DC;'>";
echo "<td>Saldo menor a $800</td>";
echo "<td>".$lowAmount."</td>";
echo "<td>".number_format(($lowAmount * 100) / $total,1)."%</td>";
echo "</tr>";

echo "<tr style='background-color:#D5D8DC;'>";
echo "<td>Cuentas repetidas</td>";
echo "<td>0</td>";
echo "<td>".number_format((0 * 100) / $total,1)."%</td>";
echo "</tr>";
@endphp
</table>
<br/><br/>
<table style="width:100%;">
    <tbody>
        <tr>
            <th style="background-color:#D5D8DC;">Base Total</th>
            <th style="background-color:#D5D8DC;">Gestionable</th>
            <th style="background-color:#D5D8DC;">No Gestionable</th>
        </tr>
        <tr>
            <td style="text-align:center">{{ ($stickersCount + $lowAmount + $processable) }}</td>
            <td style="text-align:center">{{ ($stickersCount + $lowAmount + $processable) - ($stickersCount + $lowAmount) }}</td>
            <td style="text-align:center">{{ ($stickersCount + $lowAmount) }}</td>
        </tr>
        <tr>
            <td style="text-align:center">{{ number_format((($stickersCount + $lowAmount + $processable) * 100) / $total,1) }}%</td>
            <td style="text-align:center">{{ number_format(((($stickersCount + $lowAmount + $processable) - ($stickersCount + $lowAmount)) * 100) / $total,1) }}%</td>
            <td style="text-align:center">{{ number_format((($stickersCount + $lowAmount) * 100) / $total,1) }}%</td>
        </tr>
    </tbody>
</table>
</main>
</body>
</html>