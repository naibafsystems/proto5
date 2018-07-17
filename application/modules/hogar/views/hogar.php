
<?php
echo "<h3>";
echo "El hogar seleccionado es: Hogar N&uacute;mero ";
echo $numHogar;
echo "</h3>";
echo "<div class='row>";
echo "<div class='col-xs-12' >";
for($j=0;$j<count($hogares);$j++){
    
    echo "<button type='button' class='btn btn-danger' aria-label='Left Align'>";
    ?>
    <a href="<?php echo base_url('hogar/edicionHogar/'.$hogares[$j]["H_NROHOG"]) ?>"><?php echo "HOGAR NUMERO ".$hogares[$j]["H_NROHOG"]; ?></a>
    <?php
    echo "</button>";
    
}
echo "</div>";
echo "</div>";
?>
