<?php
if (!function_exists('formatDate')) {
    function formatDate($date)
    {
        $diassemanaN = array(
            "Domingo", "Lunes", "Martes", "Miércoles",
            "Jueves", "Viernes", "Sábado"
        );
        $mesesN = array(
            1 => "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio",
            "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"
        );
        return $diassemanaN[date_format(new \DateTime($date), 'N')] 
        .' '.date_format(new \DateTime($date), 'd'). 
        ' de '.
        $mesesN[date_format(new \DateTime($date), 'n')].
        ' del '.
        date_format(new \DateTime($date), 'Y')
        .' a las '.
        date_format(new \DateTime($date),'g:i A');
    }
}
if (!function_exists('formatDateFull')) {
    function formatDateFull($date)
    {
        $diassemanaN = array(
            "Domingo", "Lunes", "Martes", "Miércoles",
            "Jueves", "Viernes", "Sábado"
        );
        $mesesN = array(
            1 => "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio",
            "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"
        );
        return $diassemanaN[date_format(new \DateTime($date), 'N')] 
        .' '.date_format(new \DateTime($date), 'd'). 
        ' de '.
        $mesesN[date_format(new \DateTime($date), 'n')].
        ' del '.
        date_format(new \DateTime($date), 'Y')
        .' a las '.
        date_format(new \DateTime($date),'g:i A');
    }
}
if (!function_exists('formatDateMonth')) {
    function formatDateMonth($date)
    {
        $mesesN = array(
            1 => "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio",
            "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"
        );
        return $mesesN[date_format(new \DateTime($date), 'n')].
        ' del '.
        date_format(new \DateTime($date), 'Y');
    }
}
if (!function_exists('readCSV')) {
    function readCSV($csvFile, $array)
    {
        $file_handle = fopen($csvFile, 'r');
        while (!feof($file_handle)) {
            $line_of_text[] = fgetcsv($file_handle, 0, $array['delimiter']);
        }
        fclose($file_handle);
        return $line_of_text;
        //$csvFileName = "test.csv";
        //$csvFile = public_path('csv/' . $csvFileName);
        //readCSV($csvFile,array('delimiter' => ','));
    }
}
if (!function_exists('onlyDate')) {
    function onlyDate($date)
    {
        $d = explode(' ',$date);
        return $d[0];
    }
}