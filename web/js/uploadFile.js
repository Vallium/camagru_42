/**
 * Created by Vallium on 18/03/2016.
 */

(function(){
    var preview         = document.querySelector('#preview'),
        buttons         = document.querySelector('#buttons'),
        inputFile       = document.querySelector('#input-file'),
        fileToUpload    = document.querySelector('#file-to-upload');
        uploadArea      = document.querySelector('#upload-area');

    document.getElementById('input-file').onchange = function (e) {
        e.preventDefault();

        var file = this.files[0];
        var url = URL.createObjectURL(file);
        var img = new Image(640, 480);

        img.src = url;
        img.setAttribute('crossOrigin', 'anonymous');
        img.setAttribute('id', 'image');

        preview.appendChild(img);
        preview.style.display = 'block';

        buttons.style.display = 'block';
        inputFile.style.display = 'none';
        fileToUpload.style.border = 'none';
        uploadArea.style.display = 'none';
    };

    document.getElementById('reset-button').addEventListener('click', function () {
        buttons.style.display = 'none';
        inputFile.style.display = 'block';
        inputFile.value = '';
        fileToUpload.style.border = '';

        document.getElementById('image').remove();

        preview.style.display = 'none';
        uploadArea.style.display = 'block';
    });

    for (var i = 0; i <= document.getElementById('nbrFilters').value; i++)
    {
        if (i == 0)
            document.getElementById('filter-' + i).style.borderColor = '#ff6800';

        document.getElementById('filter-' + i).addEventListener('click', function () {
            // console.log('Filter ' + this.alt);

            document.getElementById('calque').src = '/img/filters/' + this.alt + '.png';
            document.getElementById('filter-id').value = this.alt;
            for (var i = 0; i <= document.getElementById('nbrFilters').value; i++)
            {
                var target = document.getElementById('filter-' + i);

                if (target.alt == this.alt)
                    target.style.borderColor = '#ff6800';
                else
                    target.style.borderColor = 'transparent';
            }
        });
    }
})();