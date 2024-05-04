<?php

class Book {
    public $id;
    public $name;
    public $author;
    public $category;
    public $image;

    /* Constructor */
    public function __construct($id, $name, $author, $category, $image){
        $this->id = $id;
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
            'id' => $this->id,
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
   public function updateBook($id) {
    $url = 'https://sheetdb.io/api/v1/qvsm8ms7oiqkr/id/' . urlencode($id);
    $data = array(
        'id' => $this->id,
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
  public function deleteBook($id) {
    $url = 'https://sheetdb.io/api/v1/qvsm8ms7oiqkr/id/' . urlencode($id);
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
    $response = curl_exec($ch);
    curl_close($ch);
    return $response;
    
}
    


   //Obtener libros
    public static  function get_books(){
        return file_get_contents('https://sheetdb.io/api/v1/qvsm8ms7oiqkr');

    }

        
}

   // AGREGAR
   // Verificar si se ha enviado el formulario de agregar un nuevo libro
   if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["addBook"])) {
    $id = $_POST["id"];
    $name = $_POST["name"];
    $author = $_POST["author"];
    $category = $_POST["category"];
    $image = $_POST["image"];

    // Crear un nuevo objeto Book y agregar el libro
    $book = new Book($id, $name, $author, $category, $image);
    $book->createBook();
   }
   
   // EDITAR
   // Verificar si se ha enviado el formulario de editar un libro
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["editBook"])) {
     // Obtener los datos del formulario
     $id = $_POST["id"];
     $name = $_POST["name"]; 
     $author = $_POST["author"]; 
     $category = $_POST["category"]; 
     $image = $_POST["image"]; 
 
  

    // Crear un nuevo objeto Book y actualizar el libro
    $book = new Book($id, $name, $author, $category, $image);
    $book->updateBook($id);
      
}

    // ELIMINAR
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["deleteBook"])) {
    try {
        // Obtener el id del libro a eliminar
        $id = $_POST["id"];
       
        $book = new Book();
        $response = $book->deleteBook($id);
 
        exit(); // Salir del script después de enviar la respuesta
    } catch (Exception $e) {
        echo "Error al eliminar el libro: " . $e->getMessage();
    }
}
include_once 'addBookModal.html';
include_once 'editBookModal.html';
include_once 'bookList.php';
?>

