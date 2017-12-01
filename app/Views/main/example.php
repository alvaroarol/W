<?php $this->layout('layout', ['title' => translate('helloWorld'), 'lang' => $lang]) ?>


<?php $this->start('main_content') ?>

<div class="container">

    <h1><?= translate('helloWorld') ?></h1>

    <!-- SLIDER -->
    <section class="slider" id="slider-articles">
        <article>
            <div>
                <h1>Slide 1</h1>
                <p>texte 1</p>
            </div>
        </article>
        <article>
            <div>
                <h1>Slide 2</h1>
                <p>texte 2</p>
            </div>
        </article>
        <article>
            <div>
                <h1>Slide 3</h1>
                <p>texte 3</p>
            </div>
        </article>
    </section>

    <h2><?= translate('asdf') ?></h2>

</div>

<?php $this->stop('main_content') ?>
