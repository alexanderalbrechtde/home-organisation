<?php
require __DIR__ . '/../../partials/header.php';
?>
  <section class="hero">
    <div class="container hero__content">
      <div class="hero__text">
        <h1>Dashboard</h1>
        <p>Behalte Erinnerungen, Kategorien und FAQs im Blick.</p>
      </div>
    </div>
  </section>

  <main class="container grid">
    <article class="card">
      <header class="card__header">
        <h2>Nächste Erinnerungen</h2>
      </header>
      <div class="card__body">
        <ul class="list" id="reminders-list">
          <li class="list__item is-empty">Noch keine Erinnerungen eingetragen.</li>
        </ul>
      </div>
    </article>

    <article class="card">
      <header class="card__header">
        <h2>Kategorien</h2>
      </header>
      <div class="card__body">
        <div class="chips" id="categories">
          <span class="chip">Haushalt</span>
          <span class="chip">Finanzen</span>
          <span class="chip">Gesundheit</span>
        </div>
      </div>
    </article>

    <article class="card">
      <header class="card__header">
        <h2>FAQ</h2>
      </header>
      <div class="card__body">
        <h3>Küche</h3>
        <details class="faq">
          <summary>Wie oft muss ich was wechseln?</summary>
          <p>
              - Küchenschwamm: nach ca. 7 Tagen<br>
              - Waschlappen: nach 7 Tagen<br>
          </p>
        </details>

        <h3>Badezimmer</h3>
        <details class="faq">
          <summary>Sauberkeitsregeln(individuell anpassbar):</summary>
          <p></p>
        </details>
      </div>
    </article>
  </main>

<?php
require __DIR__ . '/../../partials/footer.php';

require_once __DIR__ . '/../auth/functions.php';
session_delete();