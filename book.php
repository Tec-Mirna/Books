<?php

class Book {
    
    public $name;
    public $author;
    public $category;
    public $image;

    /* Constructor */
    public function __construct($name, $author, $category, $image){
       
        $this->name = $name;
        $this->author = $author;
        $this->category = $category;
        $this->image = $image;
    }

    // Función para configurar la solicitud cURL(get, post, put, delete)
    private function configureCurl($url, $method, $data = null) {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        if ($data) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        }
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        return $ch;
    }

     // Método para crear un libro
    public function createBook(){
        $url = 'https://sheetdb.io/api/v1/qvsm8ms7oiqkr';

        $data = array(
            'name' => $this->name,
            'author' => $this->author,
            'category' => $this->category,
            'image' => $this->image,
        );

        $ch = $this->configureCurl($url, 'POST', $data);
        $response = curl_exec($ch);
        curl_close($ch);
        echo $response;
    }

 // Método para actualizar un libro
 public function updateBook($oldName) {
    $url = 'https://sheetdb.io/api/v1/qvsm8ms7oiqkr/name/' . urlencode($oldName);
    $data = array(
        'name' => $this->name,
        'author' => $this->author,
        'category' => $this->category,
        'image' => $this->image,
    );
    $ch = $this->configureCurl($url, 'PUT', $data);
    $response = curl_exec($ch);
    curl_close($ch);
    echo $response;
}
    


  // Método para eliminar un libro
  public function deleteBook() {
    $url = 'https://sheetdb.io/api/v1/qvsm8ms7oiqkr/name/' . urlencode($this->name);
    $ch = $this->configureCurl($url, 'DELETE');
    $response = curl_exec($ch);
    curl_close($ch);
    return $response;
}
    


   //Obtener libros
    public static  function get_books(){
        return file_get_contents('https://sheetdb.io/api/v1/qvsm8ms7oiqkr');

    }

        
}

   // Verificar si se ha enviado el formulario de agregar un nuevo libro
   if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["addBook"])) {
  
    $name = $_POST["name"];
    $author = $_POST["author"];
    $category = $_POST["category"];
    $image = $_POST["image"];

    // Crear un nuevo objeto Book y agregar el libro
    $book = new Book( $name, $author, $category, $image);
    $book->createBook();
   }
   
// Verificar si se ha enviado el formulario de editar un libro
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["editBook"])) {
    
    $name = $_POST["name"];
    $author = $_POST["author"];
    $category = $_POST["category"];
    $image = $_POST["image"];
 

    // Crear un nuevo objeto Book y actualizar el libro
    $book = new Book($name, $author, $category, $image);
    $book->updateBook($name );
}


// Eliminar

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["deleteBook"])) {
    // Obtener los datos del libro a eliminar
    $name = $_POST["name"];
    $author = $_POST["author"];
    $category = $_POST["category"];
    $image = $_POST["image"];

    // Crear un nuevo objeto Book y eliminar el libro
    $book = new Book($name, $author, $category, $image);
    $response = $book->deleteBook();

    // Devolver la respuesta al cliente
    echo $response;
    exit(); // Salir del script después de enviar la respuesta
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BOOKS</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<link rel="stylesheet" href="style.css">

</head>

<body> 

<nav class="navbar bg-body-tertiary nav-color">
  <div class="container-fluid">
  <a class="navbar-brand ">
  <img src="https://cdn-icons-png.flaticon.com/512/5833/5833290.png" alt="Logo" width="56" height="46" class="d-inline-block align-text-top">
  </a>
    <form class="d-flex " id="searchForm">
      <input id="searchInput" class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
      <button class="btn btn-outline-primary" type="submit">Search</button>
    </form>
  </div>
</nav>


  <?php
 include_once 'addBookModal.html';
 include_once 'editBookModal.html';
  ?>


<div class=" container">
        <h2 class="m-3">Libros existentes</h2>
        <!-- Se añade data-bs-toggle="modal" data-bs-target="#addBookModal" para abrir modal -->
        <button 
            class="btn btn-success add_btn" 
            data-bs-toggle="modal" data-bs-target="#addBookModal"
            
        >
        <i>Agregar</i>
      
        </button>

        <div class="row mt-3">
        <?php
        include_once './book.php';

        $books = new Book(null, null, null, null);
        $response = $books->get_books();
        $data = json_decode($response, true);

        foreach ($data as $row) {
            ?>
            <div class="card mb-3 card-b" style="max-width: 721px;">
                <div class="row g-0">
                   <div class="col-md-4">
                       <img src="<?php echo $row['image']; ?>" class="card-img-top" alt="...">
                    </div>
                    <div class="col-md-8">
                      <div class="card-body"><br>
                         <h5 class="card-title"><?php echo $row['name']; ?></h5>
                         <p>Autor:</p>
                         <h6 class="card-text"><?php echo $row['author']; ?></h5>
                         <p>Categoría:</p>
                         <h6 class="card-text"><?php echo $row['category']; ?></h6><br>
                         <!-- Botón para eliminar el libro y modificar-->
                         <button class="btn btn-outline-danger" onclick="deleteBook('<?php echo $row['name']; ?>', '<?php echo $row['author']; ?>', '<?php echo $row['category']; ?>', '<?php echo $row['image']; ?>')">Eliminar</button>
                         <button class="btn btn-outline-warning"  data-bs-toggle="modal" data-bs-target="#addBookModalEdit"  onclick="editBook('<?php echo $row['name']; ?>', '<?php echo $row['author']; ?>', '<?php echo $row['category']; ?>', '<?php echo $row['image']; ?>')">Editar</button>
                      </div>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
    </div>

    <!-- Editar -->
    <script>
   function editBook(name, author, category, image) {
    document.getElementById('edit_name').value = name;
    document.getElementById('edit_author').value = author;
    document.getElementById('edit_category').value = category;
    document.getElementById('edit_image').value = image;
    document.getElementById('old_name').value = name; // Establece el valor de oldName
    var modal = new bootstrap.Modal(document.getElementById('addBookModalEdit'));
    console.error();
    modal.show();
}

/* Ekiminar */


  function deleteBook(name, author, category, image) {
    if (confirm('¿Estás seguro de que deseas eliminar este libro?')) {
        // Construye el objeto de datos a enviar
        var data = {
            name: name,
            author: author,
            category: category,
            image: image
        };

        // Envía una solicitud AJAX al servidor para eliminar el libro
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'book.php', true);
        xhr.setRequestHeader('Content-Type', 'application/json');
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                // Maneja la respuesta del servidor
                var response = xhr.responseText;
                if (response === 'success') {
                    // Actualiza la interfaz de usuario según sea necesario
                    location.reload(); // Recarga la página después de la eliminación exitosa
                } else {
                    alert('Error al eliminar el libro');
                }
            }
        };
        // Envía los datos del libro a eliminar al servidor en formato JSON
        xhr.send(JSON.stringify(data));
    }
}

</script>

</body>
</html>
