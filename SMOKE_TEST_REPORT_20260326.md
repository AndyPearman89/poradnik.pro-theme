# Smoke Test Report — 2026-03-26

Repo: `poradnik.pro-theme_repo`  
Commit produkcyjny funkcji statusów: `1192e5d`

## Zakres
- Frontend: home + archiwa taksonomii (`kategorie`, `tematy`)
- Admin: dostępność `wp-admin`
- Markery wdrożenia: status badge modułów i chipy taxonomy

## Wyniki HTTP
- `https://poradnik.pro/` => `200`
- `https://poradnik.pro/kategorie/ogolne/` => `200`
- `https://poradnik.pro/tematy/glowny/` => `200`
- `https://poradnik.pro/wp-admin/` => `200`

## Wyniki markerów HTML
- `home` zawiera `module-status-badge` => `true`
- `home` zawiera tekst `API online` => `true`
- `kategorie/ogolne` zawiera `cpt-chip` => `true`
- `tematy/glowny` zawiera `cpt-chip` => `true`

## Wniosek
Smoke test po deploy zakończony powodzeniem: krytyczne endpointy zwracają `200`, a markery nowego UI/statusów są obecne w renderowanym HTML.
