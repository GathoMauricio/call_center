<?php
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