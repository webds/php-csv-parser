#summary 使い方について
#labels Featured,Phase-Implementation

# シンプル　ー　サンプル #
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




# すぐ使えるサンプル！ #
```
<?php

     // オブジェクトをつくる
     $csv = new File_CSV_DataSource;
  
     // 使いたいCSVの使用確認
     if ($csv->load('my_file.csv')) {
  
       // ヘッダーを配列に書き込む
       $array = $csv->getHeaders();
      
       // ヘッダーを使ってカラムのデータ配列に書き込む
       $csv->getColumn($array[2]);
      
       // ヘッダーの数や全てのデータの数が会う場合
       // ヘッダーやデータ会わせって配列に書き込む
        if ($csv->isSymmetric()) {
            // array(array('header1' => 'row1'), array('header1' => 'row2'));
            $array = $csv->connect(); // <- sample 上記の配列と同じです。
        } else {
            // ヘッダーとデータの数が会わない場合
　　　　　　// 会わない本文だけ配列に書き込む
            $array = $csv->getAsymmetricRows();
        }
      
        // 全てのヘッダー＋データを読み込む
        $array = $csv->getrawArray();
     }

?>
```