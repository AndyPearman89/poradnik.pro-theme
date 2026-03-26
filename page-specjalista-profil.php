<?php
/* Template Name: Specjalista Profil */
get_header();
?>
<section class="section landing-hero">
	<div class="container">
		<p class="meta">Strefa specjalisty</p>
		<h1>Profil specjalisty</h1>
		<p class="section-subtitle">Buduj zaufanie klientów dzięki kompletnemu profilowi, portfolio i aktualnym terminom.</p>
	</div>
</section>

<section class="section">
	<div class="container grid grid-2">
		<article class="card">
			<h2>Elementy profilu premium</h2>
			<ul>
				<li>Zweryfikowane dane firmy i obszar działania</li>
				<li>Galeria realizacji i case studies</li>
				<li>Transparentny cennik i pakiety usług</li>
			</ul>
		</article>
		<article class="card">
			<h2>Dlaczego to działa</h2>
			<p>Kompletny profil zwiększa konwersję z odwiedzin do zapytania i skraca proces decyzji klienta.</p>
			<a class="btn btn-accent" href="<?php echo esc_url(home_url('/specjalista-dashboard/')); ?>">Przejdź do dashboardu</a>
		</article>
	</div>
</section>
<?php get_footer();
