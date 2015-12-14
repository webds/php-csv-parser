#summary Simple Manual
#labels Featured

# Ejemplo Simple #
**my\_file.csv**
```
name, age
john, 13
takaka, 8
```

**php script**
```

<?php

  $csv = new File_CSV_DataSource;
 
  $csv->load('my_file.csv'); // boolean

  $csv->getHeaders(); // array('name', 'age');

  $csv->getColumn('name'); // array('john', 'tanaka');

  $csv->row(1); // array('john', '13');

  $csv->connect(); // array(
                   //   array('name' => 'john', 'age' => 13),
                   //   array('name' => 'tanaka', 'age' => 8)
                   // );

?>

```



# Un Ejemplo un poco mas complicado #
```
<?php

     // instancia
     $csv = new File_CSV_DataSource;
  
     // verifica si el archivo se puede utilizar
     if ($csv->load('my_file.csv')) {
  
       // si es asi, recoge las cabeceras y ponlas en un array
       $array = $csv->getHeaders();
      
       // utiliza la segunda cabecera y pone todos los valores
       // de la columna en un array
       $csv->getColumn($array[2]);
      
       // si las cabeceras y todos los datos concuerdan
       // crea una relacion entre cabeceras y los datos
        if ($csv->isSymmetric()) {
            // array(array('header1' => 'row1'), array('header1' => 'row2'));
            $array = $csv->connect(); // <- el array es igual que el de arriba
        } else {
　　　　　　// extrae solamente los datos no concuerdan con las cabeceras 
            $array = $csv->getAsymmetricRows();
        }
      
        // pone todos los datos de el archivo en un array
        $array = $csv->getrawArray();
     }
?>

```