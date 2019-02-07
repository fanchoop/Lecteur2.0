<div class="page-ajout">
    <form method="post" action="/admin" enctype="multipart/form-data">
        <div class="upload">
            <div class="title">Upload Zone</div>
            <div class="champs">
                <label>Musique mp3</label>
                <input id="mySound" name="foo" type="file" required="required" accept="audio/mpeg"/>
            </div>
            <div class="champs">
                <label>Cover</label>
                <input id="myCover" name="cover" type="file" required="required" accept="image/jpeg"/>
            </div>
        </div>
        <div class="champs-block">
            <div class="title">Informations de la musique</div>
            <div class="champs">
                <input type="text" name="titre" required="required" placeholder="Titre"/>
                <label>Titre *</label>
            </div>
            <div class="champs">
                <input type="text" name="album" placeholder="Album"/>
                <label>Album</label>
            </div>
            <div class="champs">
                <input type="text" name="artiste" required="required" placeholder="Artiste"/>
                <label>Artiste *</label>
            </div>
            <div class="champs">
                <input type="text" name="genre" required="required" placeholder="Genre"/>
                <label>Genre *</label>
            </div>
            <div class="champs">
                <input type="number" name="annee" required="required" min="1900" max="2019" placeholder="Année"/>
                <label>Année *</label>
            </div>
            <div class="champs">
                <input class="send" type="submit" value="Envoyer"/>
            </div>
        </div>
    </form>
</div>
