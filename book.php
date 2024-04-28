<?php

class Book {
    public $name;
    public $author;
    public $category;
    public $image;

    public function __construct($name, $author, $category, $image){
        $this->name = $name;
        $this->author = $author;
        $this->category = $category;
        $this->image = $image;
    }
    public function createBook(){
        $url = 'https://sheetdb.io/api/v1/qvsm8ms7oiqkr';

        $data = array(
            'name' => $this->name,
            'author' => $this->author,
            'category' => $this->category,
            'image' => $this->image,
        );
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data) );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

        $response= curl_exec($ch);
        curl_close($ch);
        echo $response;
    }

    

   //Obtener libros
    public function get_books(){
        $response = file_get_contents('https://sheetdb.io/api/v1/qvsm8ms7oiqkr');
        return $response;
    }

 

 
       
}

   // Verificar si se ha enviado el formulario de agregar un nuevo libro
   if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["addBook"])) {
    $name = $_POST["name"];
    $author = $_POST["author"];
    $category = $_POST["category"];
    $image = $_POST["image"];

    // Crear un nuevo objeto Book y agregar el libro
    $book = new Book($name, $author, $category, $image);
    $book->createBook();
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
<style>
    .nav-color{
        background: #EFEFBB;  /* fallback for old browsers */
        background: -webkit-linear-gradient(to right, #D4D3DD, #EFEFBB);  /* Chrome 10-25, Safari 5.1-6 */
        background: linear-gradient(to right, #D4D3DD, #EFEFBB); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */

    }
    .img{
        width: auto;
    }
    .add_btn{
        margin: 20px;
    }
    .card-b{
        border-color: white;
    }
  
   

   
</style>

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


   <!-- Modal para gregar libro-->
<div class="modal fade" id="addBookModal" tabindex="-1" aria-labelledby="addBookModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addBookModalLabel">Agregar Nuevo Libro</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="addBookForm" method="post">
          <div class="mb-3">
            <label for="name" class="form-label">Título</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Ingresa el título" require>
          </div>
          <div class="mb-3">
            <label for="author" class="form-label">Autor</label>
            <input type="text" class="form-control" id="author" name="author" placeholder="Ingresa el nombre del autor" require>
          </div>
          <div class="mb-3">
            <label for="category" class="form-label">Categoría</label>
            <input type="text" class="form-control" id="category" name="category" placeholder="Categoría">
          </div>
          <div class="mb-3">
            <label for="image" class="form-label">Categoría</label>
            <input type="text" class="form-control" id="image" name="image" placeholder="Url">
          </div>
          <button type="submit"  name="addBook" class="btn btn-info">Agregar Libro</button>
        </form>
      </div>
    </div>
  </div>
</div>


 <!-- Modal para editar libro-->
 <div class="modal fade" id="addBookModalEdit" tabindex="-1" aria-labelledby="addBookModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addBookModalLabel">Editar Libro</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editBookForm" method="post" action="book.php">
            
                    <div class="mb-3">
                        <label for="edit_name" class="form-label">Título</label>
                        <input type="text" class="form-control" id="edit_name" name="name" placeholder="Ingresa el título" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_author" class="form-label">Autor</label>
                        <input type="text" class="form-control" id="edit_author" name="author" placeholder="Ingresa el nombre del autor" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_category" class="form-label">Categoría</label>
                        <input type="text" class="form-control" id="edit_category" name="category" placeholder="Categoría">
                    </div>
                    <div class="mb-3">
                        <label for="edit_image" class="form-label">Categoría</label>
                        <input type="text" class="form-control" id="edit_image" name="image" placeholder="Url">
                    </div>
                  
                    <button type="submit" class="btn btn-info">Aceptar</button>
                </form>
            </div>
        </div>
    </div>
</div>



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

   
    var modal = new bootstrap.Modal(document.getElementById('addBookModalEdit'));
    modal.show();
}
</script>





</body>
</html>
