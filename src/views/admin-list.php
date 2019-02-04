<div class="page-list">
    <div class="title">Liste des musiques</div>
    <ul class="list">
        <li class="head">
            <p class="image"></p>
            <p class="id">ID</p>
            <p class="titre">Titre</p>
            <p class="artiste">Artiste</p>
            <p class="album">Album</p>
            <p class="genre">Genre(s)</p>
            <p class="annee">Année</p>
            <p class="modif"></p>
            <p class="suppr"></p>
        </li>
        <?php echo $list ?>
    </ul>
    <!--Modal-->
    <div class="modal_suppr">
        <div class="modal-content">
            <div class="modal-header"><span class="close">×</span>
                <p>Attention</p>
            </div>
            <div class="modal-body">
                <p>Voulez-vous vraiment supprimer la musique ?</p>
                <button class="annuler">Annuler</button>
                <form method="post" action="/admin/del/undefined" enctype="multipart/form-data">
                    <input class="suppr" type="submit" value="Supprimer"/>
                </form>
            </div>
        </div>
    </div>
</div>