
<nav class="pagination is-centered is-rounded " role="navigation" aria-label="pagination">

    <a href="#" class="pagination-previous">Previous</a>

    <ul class="pagination-list">
        <li>
            <a href="#" class="pagination-link ">1</a>
        </li>
        <li><span class="pagination-ellipsis">&hellip;</span></li>
        <li>
            <a class="pagination-link is-current" href="#">2</a>
        </li>
        <li>
            <a href="#" class="pagination-link" href="#">3</a>
        </li>
        <li><span class="pagination-ellipsis">&hellip;</span></li>
        <li><a href="#" class="pagination-link" href="#">3</a></li>
    </ul>

    <a href="#" class="pagination-next">Next page</a>

</nav>

<style>

    .pagination{
        padding: 40px;
    }
    /* Define el color del elemento activo en la paginación */
    .pagination-link.is-current {
        background-color: rgba(65, 1, 1, 0.955); /* Color azul, puedes usar cualquier color que desees */
        color: white; /* Color del texto en el elemento activo */
    }
    .pagination-next{
        background-color: #6B0015; /* Color azul, puedes usar cualquier color que desees */
        color: white; /* Color del texto en el elemento activo */
    }
    .pagination-previous{
        background-color: #6B0015; /* Color azul, puedes usar cualquier color que desees */
        color: white; /* Color del texto en el elemento activo */
    }
</style>
