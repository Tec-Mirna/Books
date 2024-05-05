<?php
include_once './bookList.php';
?>

<script>


   // BUSQUEDA
     function searchBooks() {

    // Obtener el valor del input de búsqueda
    let inputValue = document.getElementById('searchInput').value;

    let url = `https://sheetdb.io/api/v1/qvsm8ms7oiqkr/search_or?name=${inputValue}&author=${inputValue}&category=${inputValue}`;

     // Ocultar los resultados existentes
     document.getElementById('searchResults').innerHTML = '';

    // solicitud GET  con el término de búsqueda
    fetch(url)
        .then(response => response.json())
        .then(data => {
            
            // si se encuntran oincidencias con la búsqueda, mostrar
            if (data.length > 0) {

              // Mostrar los resultados 
            data.forEach(book => {
                // crear tarjeta
                let bookCard = `
                <h5  style="color: green;">Resultado de tu búsqueda</h5><br>
                    <div class="card mb-3" style="max-width: 500px;     background-color: #D4D3DD;">
                    <div class="row g-0">
                      <div class="col-md-4">
                          <img class="card-img-top" src="${book.image}" />
                     </div>
                     <div class="col-md-8">
                        <div class="card-body">
                            <h4 class="card-title">${book.name}</h4>
                            <p>Autor</p>
                            <h6 class="card-text">${book.author}</h6>
                            <p>Categoría</p>
                            <h6 class="card-text">${book.category}</h6>
                            
                            </div>
                        </div>
                        </div>
                    </div> 
                
                `;
                // mostrar tarjeta del libro en resultados
                document.getElementById('searchResults').innerHTML += bookCard;
               
            });
        } else {
            // si no se encuentra resultado, mostrar esta alerta
            document.getElementById('searchResults').innerHTML = '<p class="alert alert-danger" role="alert">No se encontraron resultados para tu búsqueda</p>';
        }
        })
        .catch(error => console.error('Error:', error))
        .finally(() => {
            //limpiar el input luego de la búsqueda
            document.getElementById('searchInput').value = '';
        })
}

// escucha si se envía el form de búsqueda
document.getElementById('searchForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Evitar que se recargue 
    searchBooks(); // Llamar a la función de búsqueda
});










</script>