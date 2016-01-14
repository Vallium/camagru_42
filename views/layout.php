<!DOCTYPE html>
<html>
    <head>
        <title>Mon Title</title>
    </head>

    <body>
        <header>
            <?php if ($user->isConnected()): ?>
            Connecter
            <?php else: ?>
            Pas connecter
            <?php endif; ?>
        </header>
        <?php echo $content_for_layout; ?>

        <section>
            <?php foreach($news as $new): ?>
                <article>
                    <h1><?php echo $new->title; ?></h1>
                </article>
            <?php endforeach; ?>

            {% for new in news %}

            {% endfor %}
        </section>


    </body>
</html>