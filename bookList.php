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

        $books = new Book(null, null, null, null, null);
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
                      <div class="card-body">
                         <h5 class="card-title"><?php echo $row['name']; ?></h5>
                         <p>Autor:</p>
                         <h6 class="card-text"><?php echo $row['author']; ?></h5>
                         <p>Categoría:</p>
                         <h6 class="card-text"><?php echo $row['category']; ?></h6><br>
                         <!-- Botón para eliminar el libro y modificar-->       <!--atributo: data-bookid almacena el ID del libro asociado al botón de eliminar -->
                         <button class=" btn btn-outline-danger btn-delete"  data-bookid="<?php echo $row['id']; ?>">Eliminar</button>
                         <button class="btn btn-outline-warning"  data-bs-toggle="modal" data-bs-target="#addBookModalEdit"  onclick="editBook('<?php echo $row['id']; ?>', '<?php echo $row['name']; ?>', '<?php echo $row['author']; ?>', '<?php echo $row['category']; ?>', '<?php echo $row['image']; ?>')">Editar</button>
                      </div>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
    </div>

    <script>
  


   /* Eliminar por id */
    function deleteBook(id) {
        if (confirm('¿Estás seguro de que deseas eliminar este libro?')) {
            const endpoint = `https://sheetdb.io/api/v1/qvsm8ms7oiqkr/id/${id}`;

            fetch(endpoint, {
                method: 'DELETE'
            })
            .then(response => {
                if (response.ok) {
                
                    location.reload(); 
                } else {
                    throw new Error('Error al eliminar el libro');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al eliminar el libro');
            });
        }
    }

    // Agrega un evento clic a todos los botones de eliminación atributo (data-bookid) inicia con data-seguidodeloquesea
    document.querySelectorAll('.btn-delete').forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.getAttribute('data-bookid');
            deleteBook(id);
        });
    });
</script>

</body>
</html>
