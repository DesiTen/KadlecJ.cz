<?php
/**
 * Jan Kadlec Theme — SEO Infrastruktura
 *
 * Obsahuje kompletní SEO vrstvu šablony:
 *  1. Detekce SEO pluginů (Yoast / Rank Math / AIOSEO)
 *  2. Document title — separator a úprava částí
 *  3. Meta tagy — description, canonical, Open Graph, Twitter Card, robots
 *  4. JSON-LD schémata — WebSite, Person, Service, Article, BreadcrumbList
 *  5. WordPress Customizer — SEO pole editovatelná bez kódu
 *  6. Admin meta box — SEO přepisy na úrovni každého příspěvku / stránky
 *  7. Pomocné funkce — gettery pro meta hodnoty
 *
 * @package jan-kadlec-theme
 * @version 1.0.0
 */

defined( 'ABSPATH' ) || exit;


/* ============================================================
   1. DETEKCE SEO PLUGINŮ
   Pokud je nainstalován Yoast, Rank Math nebo AIOSEO,
   přenecháme meta tagy a schémata jim a registrujeme jen
   Customizer sekci a admin meta box jako zálohu.
   ============================================================ */

function jk_has_seo_plugin(): bool {
    return defined( 'WPSEO_VERSION' )          // Yoast SEO
        || defined( 'RANK_MATH_VERSION' )       // Rank Math
        || class_exists( 'AIOSEO\Plugin\AIOSEO' ); // All in One SEO
}


/* ============================================================
   2. DOCUMENT TITLE
   ============================================================ */

// Oddělovač titulku: "Název stránky | Jan Kadlec"
add_filter( 'document_title_separator', fn() => '|' );

/**
 * Upraví části titulku — přidá vlastní SEO titulek z meta boxu.
 */
add_filter( 'document_title_parts', function ( array $parts ): array {
    if ( ! is_front_page() && is_singular() ) {
        $custom = get_post_meta( get_the_ID(), '_jk_meta_title', true );
        if ( $custom ) {
            $parts['title'] = wp_strip_all_tags( $custom );
        }
    }
    return $parts;
} );

// hreflang pro česky psaný web
add_action( 'wp_head', function (): void {
    echo '<link rel="alternate" hreflang="cs" href="' . esc_url( home_url( '/' ) ) . '">' . "\n";
    echo '<link rel="alternate" hreflang="x-default" href="' . esc_url( home_url( '/' ) ) . '">' . "\n";
}, 1 );


/* ============================================================
   3. META TAGY
   Spuštěno pouze pokud není aktivní SEO plugin.
   ============================================================ */

if ( ! jk_has_seo_plugin() ) {
    add_action( 'wp_head', 'jk_output_meta_tags', 2 );
}

function jk_output_meta_tags(): void {

    $description = jk_get_meta_description();
    $canonical   = jk_get_canonical_url();
    $og_image    = jk_get_og_image_url();
    $title       = jk_get_page_title_for_meta();
    $site_name   = get_bloginfo( 'name' );
    $twitter     = get_theme_mod( 'jk_twitter_handle', '' );
    $robots      = jk_get_robots_meta();
    $google_v    = get_theme_mod( 'jk_google_verification', '' );

    // ---- Robots ------------------------------------------------
    if ( $robots ) {
        echo '<meta name="robots" content="' . esc_attr( $robots ) . '">' . "\n";
    }

    // ---- Google Search Console verifikace ----------------------
    if ( $google_v ) {
        echo '<meta name="google-site-verification" content="' . esc_attr( $google_v ) . '">' . "\n";
    }

    // ---- Meta description --------------------------------------
    if ( $description ) {
        echo '<meta name="description" content="' . esc_attr( $description ) . '">' . "\n";
    }

    // ---- Canonical URL -----------------------------------------
    echo '<link rel="canonical" href="' . esc_url( $canonical ) . '">' . "\n";

    // ---- Open Graph --------------------------------------------
    echo '<meta property="og:type"        content="' . esc_attr( is_singular() ? 'article' : 'website' ) . '">' . "\n";
    echo '<meta property="og:title"       content="' . esc_attr( $title ) . '">' . "\n";
    echo '<meta property="og:description" content="' . esc_attr( $description ) . '">' . "\n";
    echo '<meta property="og:url"         content="' . esc_url( $canonical ) . '">' . "\n";
    echo '<meta property="og:site_name"   content="' . esc_attr( $site_name ) . '">' . "\n";
    echo '<meta property="og:locale"      content="cs_CZ">' . "\n";

    if ( $og_image ) {
        echo '<meta property="og:image"       content="' . esc_url( $og_image ) . '">' . "\n";
        echo '<meta property="og:image:width" content="1200">' . "\n";
        echo '<meta property="og:image:height" content="630">' . "\n";
        echo '<meta property="og:image:alt"   content="' . esc_attr( $title ) . '">' . "\n";
    }

    // ---- Twitter / X Card -------------------------------------
    echo '<meta name="twitter:card"        content="summary_large_image">' . "\n";
    echo '<meta name="twitter:title"       content="' . esc_attr( $title ) . '">' . "\n";
    echo '<meta name="twitter:description" content="' . esc_attr( $description ) . '">' . "\n";
    if ( $og_image ) {
        echo '<meta name="twitter:image"   content="' . esc_url( $og_image ) . '">' . "\n";
    }
    if ( $twitter ) {
        echo '<meta name="twitter:site"    content="@' . esc_attr( ltrim( $twitter, '@' ) ) . '">' . "\n";
    }

    // ---- Article meta (pro singulární příspěvky) ---------------
    if ( is_singular() && ! is_front_page() ) {
        echo '<meta property="article:published_time" content="' . esc_attr( get_the_date( 'c' ) ) . '">' . "\n";
        echo '<meta property="article:modified_time"  content="' . esc_attr( get_the_modified_date( 'c' ) ) . '">' . "\n";
        echo '<meta property="article:author"         content="' . esc_attr( get_the_author() ) . '">' . "\n";
    }
}


/* ============================================================
   4. JSON-LD SCHÉMATA
   Spuštěno pouze pokud není aktivní SEO plugin.
   ============================================================ */

if ( ! jk_has_seo_plugin() ) {
    add_action( 'wp_head', 'jk_output_schema', 3 );
}

function jk_output_schema(): void {
    $graphs = [];

    // --- WebSite (vždy) ----------------------------------------
    $graphs[] = [
        '@type'           => 'WebSite',
        '@id'             => home_url( '/#website' ),
        'url'             => home_url( '/' ),
        'name'            => get_bloginfo( 'name' ),
        'description'     => jk_get_meta_description(),
        'inLanguage'      => 'cs-CZ',
        'potentialAction' => [
            '@type'       => 'SearchAction',
            'target'      => [
                '@type'       => 'EntryPoint',
                'urlTemplate' => home_url( '/?s={search_term_string}' ),
            ],
            'query-input' => 'required name=search_term_string',
        ],
    ];

    // --- Person (vždy — autor webu) ----------------------------
    $graphs[] = jk_schema_person();

    // --- ProfessionalService (úvodní strana) -------------------
    if ( is_front_page() ) {
        $graphs[] = jk_schema_professional_service();
    }

    // --- Article (singulární příspěvek) -------------------------
    if ( is_singular( 'post' ) ) {
        $graphs[] = jk_schema_article();
    }

    // --- Service (CPT jk_service) --------------------------------
    if ( is_singular( 'jk_service' ) ) {
        $graphs[] = jk_schema_cpt_service();
    }

    // --- BreadcrumbList (vše kromě homepage) --------------------
    if ( ! is_front_page() ) {
        $bc = jk_schema_breadcrumbs_data();
        if ( $bc ) {
            $graphs[] = $bc;
        }
    }

    // Výstup jako @graph
    $ld = [
        '@context' => 'https://schema.org',
        '@graph'   => $graphs,
    ];

    echo '<script type="application/ld+json">' . "\n";
    echo wp_json_encode( $ld, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT );
    echo "\n" . '</script>' . "\n";
}

/**
 * Schema: Person — Jan Kadlec
 */
function jk_schema_person(): array {
    $person_desc = get_theme_mod(
        'jk_schema_person_description',
        'Jsem Managing Director v marketingové agentuře CreatiCom a expert na AI strategii a business automatizace pro střední a velké podniky.'
    );
    $linkedin    = get_theme_mod( 'jk_linkedin_url', 'https://linkedin.com/in/jankadlec' );

    return [
        '@type'       => 'Person',
        '@id'         => home_url( '/#person' ),
        'name'        => 'Jan Kadlec',
        'givenName'   => 'Jan',
        'familyName'  => 'Kadlec',
        'jobTitle'    => 'AI Stratég & Business Konzultant',
        'description' => $person_desc,
        'url'         => home_url( '/' ),
        'image'       => [
            '@type' => 'ImageObject',
            'url'   => JK_THEME_URI . '/assets/images/JK-silueta.png',
        ],
        'sameAs'      => array_filter( [
            $linkedin,
            'https://creaticom.cz',
        ] ),
        'worksFor'    => [
            '@type' => 'Organization',
            'name'  => 'CreatiCom',
            'url'   => 'https://creaticom.cz',
        ],
        'knowsAbout'  => [
            'Artificial Intelligence',
            'Business Automation',
            'AI Strategy',
            'Process Automation',
            'Make (Integromat)',
            'LLM Integration',
            'Digital Marketing',
            'Business Consulting',
        ],
        'address'     => [
            '@type'           => 'PostalAddress',
            'addressLocality' => 'Praha',
            'addressCountry'  => 'CZ',
        ],
    ];
}

/**
 * Schema: ProfessionalService — konzultantská firma
 */
function jk_schema_professional_service(): array {
    return [
        '@type'           => 'ProfessionalService',
        '@id'             => home_url( '/#service' ),
        'name'            => 'Jan Kadlec – AI Strategie & Business Automatizace',
        'description'     => 'Navrhuji a stavím AI automatizace pro střední a velké podniky. Audit procesů, strategie, implementace a rapid prototyping.',
        'url'             => home_url( '/' ),
        'areaServed'      => [
            [ '@type' => 'Country', 'name' => 'Česká republika' ],
            [ '@type' => 'Country', 'name' => 'Slovensko' ],
        ],
        'founder'         => [ '@id' => home_url( '/#person' ) ],
        'priceRange'      => '$$',
        'hasOfferCatalog' => [
            '@type'           => 'OfferCatalog',
            'name'            => 'AI & Automatizační služby',
            'itemListElement' => [
                [
                    '@type'       => 'Offer',
                    'itemOffered' => [
                        '@type'       => 'Service',
                        'name'        => 'AI Strategie & Audit',
                        'description' => 'Identifikace kritických míst ve workflow a návrh AI strategie s měřitelnou návratností.',
                    ],
                ],
                [
                    '@type'       => 'Offer',
                    'itemOffered' => [
                        '@type'       => 'Service',
                        'name'        => 'Procesní automatizace na míru',
                        'description' => 'Propojení CRM, ERP a interních nástrojů do autonomních celků pomocí Make a custom řešení.',
                    ],
                ],
                [
                    '@type'       => 'Offer',
                    'itemOffered' => [
                        '@type'       => 'Service',
                        'name'        => 'Rapid Prototyping',
                        'description' => 'Rychlý vývoj interních aplikací a MVP metodikou Vibe Coding v řádu dnů.',
                    ],
                ],
            ],
        ],
    ];
}

/**
 * Schema: Article — pro singulární příspěvky blogu
 */
function jk_schema_article(): array {
    return [
        '@type'            => 'Article',
        '@id'              => get_permalink() . '#article',
        'headline'         => get_the_title(),
        'description'      => jk_get_meta_description(),
        'url'              => get_permalink(),
        'datePublished'    => get_the_date( 'c' ),
        'dateModified'     => get_the_modified_date( 'c' ),
        'author'           => [ '@id' => home_url( '/#person' ) ],
        'publisher'        => [ '@id' => home_url( '/#person' ) ],
        'inLanguage'       => 'cs-CZ',
        'image'            => has_post_thumbnail()
            ? get_the_post_thumbnail_url( null, 'jk-hero' )
            : jk_get_og_image_url(),
        'isPartOf'         => [ '@id' => home_url( '/#website' ) ],
        'mainEntityOfPage' => [ '@id' => get_permalink() ],
    ];
}

/**
 * Schema: Service — pro CPT jk_service
 */
function jk_schema_cpt_service(): array {
    return [
        '@type'       => 'Service',
        '@id'         => get_permalink() . '#service',
        'name'        => get_the_title(),
        'description' => jk_get_meta_description(),
        'url'         => get_permalink(),
        'provider'    => [ '@id' => home_url( '/#person' ) ],
        'areaServed'  => 'CZ',
        'inLanguage'  => 'cs-CZ',
    ];
}

/**
 * Schema data pro BreadcrumbList — vrací pole nebo null.
 */
function jk_schema_breadcrumbs_data(): ?array {
    $items    = [];
    $position = 1;

    // Vždy začínáme Domovskou stránkou
    $items[] = [
        '@type'    => 'ListItem',
        'position' => $position++,
        'name'     => 'Domů',
        'item'     => home_url( '/' ),
    ];

    // Archiv CPT
    if ( is_singular( 'jk_service' ) ) {
        $items[] = [
            '@type'    => 'ListItem',
            'position' => $position++,
            'name'     => 'Služby',
            'item'     => home_url( '/sluzby/' ),
        ];
    } elseif ( is_singular( 'jk_reference' ) || is_post_type_archive( 'jk_reference' ) ) {
        $items[] = [
            '@type'    => 'ListItem',
            'position' => $position++,
            'name'     => 'Případové studie',
            'item'     => get_post_type_archive_link( 'jk_reference' ),
        ];
    } elseif ( is_singular( 'post' ) ) {
        $cat = get_the_category();
        if ( $cat ) {
            $items[] = [
                '@type'    => 'ListItem',
                'position' => $position++,
                'name'     => $cat[0]->name,
                'item'     => get_category_link( $cat[0]->term_id ),
            ];
        }
    }

    // Aktuální stránka (bez URL — pouze název)
    if ( is_singular() ) {
        $items[] = [
            '@type'    => 'ListItem',
            'position' => $position,
            'name'     => get_the_title(),
            'item'     => get_permalink(),
        ];
    } elseif ( is_archive() ) {
        $items[] = [
            '@type'    => 'ListItem',
            'position' => $position,
            'name'     => get_the_archive_title(),
            'item'     => get_pagenum_link(),
        ];
    }

    if ( count( $items ) < 2 ) {
        return null;
    }

    return [
        '@type'           => 'BreadcrumbList',
        'itemListElement' => $items,
    ];
}


/* ============================================================
   5. PAGINAČNÍ HINTS
   rel="prev" / rel="next" pro archivy
   ============================================================ */

add_action( 'wp_head', function (): void {
    global $paged, $wp_query;

    if ( ! is_singular() ) {
        $max = (int) $wp_query->max_num_pages;
        if ( $paged > 1 ) {
            echo '<link rel="prev" href="' . esc_url( get_pagenum_link( $paged - 1 ) ) . '">' . "\n";
        }
        if ( $paged < $max ) {
            echo '<link rel="next" href="' . esc_url( get_pagenum_link( $paged + 1 ) ) . '">' . "\n";
        }
    }
}, 4 );


/* ============================================================
   6. ROBOTS META
   Automaticky noindex pro vyhledávání, 404, přihlášení
   ============================================================ */

add_action( 'wp_head', function (): void {
    $noindex_conditions = is_search() || is_404() || is_date();
    if ( apply_filters( 'jk_noindex', $noindex_conditions ) ) {
        echo '<meta name="robots" content="noindex, follow">' . "\n";
    }
}, 1 );


/* ============================================================
   7. CUSTOMIZER — SEO & Sociální sítě sekce
   ============================================================ */

add_action( 'customize_register', function ( WP_Customize_Manager $wp_customize ): void {

    // Sekce
    $wp_customize->add_section( 'jk_seo_section', [
        'title'       => __( 'SEO & Sociální sítě', 'jan-kadlec-theme' ),
        'description' => __( 'Globální SEO nastavení. Pro přepisy na úrovni stránky použijte meta box v editoru.', 'jan-kadlec-theme' ),
        'priority'    => 30,
        'capability'  => 'edit_theme_options',
    ] );

    $fields = [
        // Meta popis webu
        [
            'id'      => 'jk_meta_description',
            'label'   => 'Výchozí meta popis webu',
            'type'    => 'textarea',
            'default' => 'Pomáhám středním a velkým podnikům transformovat chaos v procesech v měřitelný výkon. AI strategie, procesní automatizace, rapid prototyping.',
        ],
        // OG obrázek
        [
            'id'      => 'jk_og_image_url',
            'label'   => 'Výchozí OG obrázek (URL)',
            'type'    => 'url',
            'default' => '',
        ],
        // LinkedIn
        [
            'id'      => 'jk_linkedin_url',
            'label'   => 'LinkedIn URL',
            'type'    => 'url',
            'default' => 'https://linkedin.com/in/jankadlec',
        ],
        // Twitter / X
        [
            'id'      => 'jk_twitter_handle',
            'label'   => 'Twitter / X handle (bez @)',
            'type'    => 'text',
            'default' => '',
        ],
        // Google Search Console
        [
            'id'      => 'jk_google_verification',
            'label'   => 'Google Search Console verifikace',
            'type'    => 'text',
            'default' => '',
        ],
        // Popis osoby pro Schema
        [
            'id'      => 'jk_schema_person_description',
            'label'   => 'Popis osoby (Schema.org Person)',
            'type'    => 'textarea',
            'default' => 'Managing Director v CreatiCom a expert na AI strategii a business automatizace pro střední a velké podniky.',
        ],
    ];

    foreach ( $fields as $f ) {
        $wp_customize->add_setting( $f['id'], [
            'default'           => $f['default'],
            'sanitize_callback' => $f['type'] === 'url' ? 'esc_url_raw' : 'sanitize_text_field',
            'transport'         => 'refresh',
        ] );
        $wp_customize->add_control( $f['id'], [
            'label'   => $f['label'],
            'section' => 'jk_seo_section',
            'type'    => $f['type'],
        ] );
    }
} );


/* ============================================================
   8. ADMIN META BOX — SEO přepisy na úrovni příspěvku
   ============================================================ */

add_action( 'add_meta_boxes', function (): void {
    $post_types = [ 'post', 'page', 'jk_service', 'jk_reference' ];
    add_meta_box(
        'jk_seo_meta_box',
        '🔍 SEO nastavení',
        'jk_render_seo_meta_box',
        $post_types,
        'normal',
        'high'
    );
} );

function jk_render_seo_meta_box( WP_Post $post ): void {
    wp_nonce_field( 'jk_seo_meta_box_save', 'jk_seo_nonce' );

    $meta_title  = get_post_meta( $post->ID, '_jk_meta_title',       true );
    $meta_desc   = get_post_meta( $post->ID, '_jk_meta_description',  true );
    $og_img      = get_post_meta( $post->ID, '_jk_og_image_url',      true );
    $canonical   = get_post_meta( $post->ID, '_jk_canonical',         true );
    $noindex     = get_post_meta( $post->ID, '_jk_noindex',           true );

    $char_title  = mb_strlen( $meta_title );
    $char_desc   = mb_strlen( $meta_desc );
    ?>
    <style>
        .jk-seo-box { display:grid; gap:16px; }
        .jk-seo-field label { display:block; font-weight:600; margin-bottom:4px; font-size:13px; }
        .jk-seo-field input[type=text],
        .jk-seo-field input[type=url],
        .jk-seo-field textarea { width:100%; box-sizing:border-box; }
        .jk-seo-counter { font-size:11px; color:#888; text-align:right; margin-top:3px; }
        .jk-seo-counter.warn { color:#d63638; }
        .jk-seo-preview { background:#f6f7f7; border:1px solid #ddd; border-radius:4px; padding:12px 16px; margin-top:8px; }
        .jk-seo-preview-title { color:#1a0dab; font-size:18px; margin:0 0 2px; text-decoration:underline; cursor:pointer; }
        .jk-seo-preview-url { color:#006621; font-size:13px; margin:0 0 4px; }
        .jk-seo-preview-desc { color:#545454; font-size:13px; margin:0; line-height:1.5; }
        .jk-seo-hint { font-size:11px; color:#666; margin-top:3px; }
        .jk-seo-sep { border:0; border-top:1px solid #e2e4e7; margin:4px 0; }
    </style>

    <div class="jk-seo-box">

        <!-- SEO titulek -->
        <div class="jk-seo-field">
            <label for="jk_meta_title">SEO titulek</label>
            <input
                type="text"
                id="jk_meta_title"
                name="jk_meta_title"
                value="<?php echo esc_attr( $meta_title ); ?>"
                placeholder="Ponechte prázdné pro automatický titulek"
                maxlength="70"
            >
            <div class="jk-seo-counter <?php echo $char_title > 60 ? 'warn' : ''; ?>" id="jk-title-counter">
                <?php echo (int) $char_title; ?> / 60 znaků (max 60 pro Google)
            </div>
        </div>

        <!-- Meta popis -->
        <div class="jk-seo-field">
            <label for="jk_meta_description">Meta popis</label>
            <textarea
                id="jk_meta_description"
                name="jk_meta_description"
                rows="3"
                placeholder="Popis zobrazený ve výsledcích vyhledávání (120–160 znaků)"
                maxlength="200"
            ><?php echo esc_textarea( $meta_desc ); ?></textarea>
            <div class="jk-seo-counter <?php echo ( $char_desc > 160 || ( $char_desc > 0 && $char_desc < 120 ) ) ? 'warn' : ''; ?>" id="jk-desc-counter">
                <?php echo (int) $char_desc; ?> / 160 znaků (doporučeno 120–160)
            </div>
        </div>

        <!-- SERP náhled -->
        <div class="jk-seo-preview" id="jk-serp-preview">
            <p class="jk-seo-preview-title" id="jk-preview-title">
                <?php echo esc_html( $meta_title ?: get_the_title( $post ) ); ?> | <?php echo esc_html( get_bloginfo( 'name' ) ); ?>
            </p>
            <p class="jk-seo-preview-url">kadlecj.cz › <?php echo esc_html( $post->post_name ?: 'url-stranky' ); ?></p>
            <p class="jk-seo-preview-desc" id="jk-preview-desc">
                <?php echo esc_html( $meta_desc ?: wp_trim_words( $post->post_content, 28 ) ); ?>
            </p>
        </div>

        <hr class="jk-seo-sep">

        <!-- OG obrázek -->
        <div class="jk-seo-field">
            <label for="jk_og_image_url">OG obrázek URL (1200 × 630 px)</label>
            <input
                type="url"
                id="jk_og_image_url"
                name="jk_og_image_url"
                value="<?php echo esc_url( $og_img ); ?>"
                placeholder="https://..."
            >
            <p class="jk-seo-hint">Používá se pro sdílení na sociálních sítích. Ponechte prázdné pro výchozí obrázek.</p>
        </div>

        <!-- Canonical URL -->
        <div class="jk-seo-field">
            <label for="jk_canonical">Canonical URL</label>
            <input
                type="url"
                id="jk_canonical"
                name="jk_canonical"
                value="<?php echo esc_url( $canonical ); ?>"
                placeholder="Ponechte prázdné pro automatický canonical"
            >
            <p class="jk-seo-hint">Nastavte jen pokud chcete explicitně přepsat canonical (duplicitní obsah).</p>
        </div>

        <!-- Noindex -->
        <div class="jk-seo-field">
            <label>
                <input
                    type="checkbox"
                    name="jk_noindex"
                    value="1"
                    <?php checked( $noindex, '1' ); ?>
                >
                Neindexovat tuto stránku (noindex)
            </label>
            <p class="jk-seo-hint">Zabrání Google indexovat tuto stránku. Použijte pro děkovné stránky, duplicity atd.</p>
        </div>

    </div>

    <script>
    ( function() {
        const titleInput = document.getElementById('jk_meta_title');
        const descInput  = document.getElementById('jk_meta_description');
        const titleCnt   = document.getElementById('jk-title-counter');
        const descCnt    = document.getElementById('jk-desc-counter');
        const prevTitle  = document.getElementById('jk-preview-title');
        const prevDesc   = document.getElementById('jk-preview-desc');
        const siteName   = '<?php echo esc_js( get_bloginfo( 'name' ) ); ?>';
        const postTitle  = '<?php echo esc_js( get_the_title( $post ) ); ?>';

        function updateTitle() {
            const len = titleInput.value.length;
            titleCnt.textContent = len + ' / 60 znaků (max 60 pro Google)';
            titleCnt.classList.toggle('warn', len > 60);
            prevTitle.textContent = ( titleInput.value || postTitle ) + ' | ' + siteName;
        }

        function updateDesc() {
            const len = descInput.value.length;
            descCnt.textContent = len + ' / 160 znaků (doporučeno 120–160)';
            descCnt.classList.toggle('warn', len > 160 || (len > 0 && len < 120));
            prevDesc.textContent = descInput.value || '<?php echo esc_js( wp_trim_words( $post->post_content, 28 ) ); ?>';
        }

        if (titleInput) { titleInput.addEventListener('input', updateTitle); updateTitle(); }
        if (descInput)  { descInput.addEventListener('input', updateDesc);  updateDesc();  }
    } )();
    </script>
    <?php
}

add_action( 'save_post', function ( int $post_id ): void {
    // Bezpečnostní kontroly
    if (
        ! isset( $_POST['jk_seo_nonce'] )
        || ! wp_verify_nonce( $_POST['jk_seo_nonce'], 'jk_seo_meta_box_save' )
        || defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE
        || ! current_user_can( 'edit_post', $post_id )
    ) {
        return;
    }

    $text_fields = [
        'jk_meta_title'       => '_jk_meta_title',
        'jk_meta_description' => '_jk_meta_description',
    ];

    $url_fields = [
        'jk_og_image_url' => '_jk_og_image_url',
        'jk_canonical'    => '_jk_canonical',
    ];

    foreach ( $text_fields as $post_key => $meta_key ) {
        $value = isset( $_POST[ $post_key ] ) ? sanitize_text_field( wp_unslash( $_POST[ $post_key ] ) ) : '';
        update_post_meta( $post_id, $meta_key, $value );
    }

    foreach ( $url_fields as $post_key => $meta_key ) {
        $value = isset( $_POST[ $post_key ] ) ? esc_url_raw( wp_unslash( $_POST[ $post_key ] ) ) : '';
        update_post_meta( $post_id, $meta_key, $value );
    }

    $noindex = isset( $_POST['jk_noindex'] ) ? '1' : '0';
    update_post_meta( $post_id, '_jk_noindex', $noindex );
} );


/* ============================================================
   9. POMOCNÉ FUNKCE (gettery)
   ============================================================ */

/**
 * Vrátí optimální meta popis pro aktuální stránku.
 */
function jk_get_meta_description(): string {
    // 1. Custom meta box přepis
    if ( is_singular() ) {
        $custom = get_post_meta( get_the_ID(), '_jk_meta_description', true );
        if ( $custom ) {
            return wp_strip_all_tags( $custom );
        }
        // 2. Excerpt příspěvku
        $excerpt = get_the_excerpt();
        if ( $excerpt ) {
            return wp_strip_all_tags( $excerpt );
        }
    }

    // 3. Customizer výchozí popis
    $customizer = get_theme_mod(
        'jk_meta_description',
        'Pomáhám středním a velkým podnikům transformovat chaos v procesech v měřitelný výkon. AI strategie, procesní automatizace, rapid prototyping.'
    );
    if ( $customizer ) {
        return wp_strip_all_tags( $customizer );
    }

    // 4. WordPress tagline
    return wp_strip_all_tags( get_bloginfo( 'description' ) );
}

/**
 * Vrátí správnou canonical URL pro aktuální stránku.
 */
function jk_get_canonical_url(): string {
    // 1. Meta box přepis
    if ( is_singular() ) {
        $custom = get_post_meta( get_the_ID(), '_jk_canonical', true );
        if ( $custom ) {
            return esc_url( $custom );
        }
        return esc_url( get_permalink() );
    }

    // 2. Archivy a paginácia
    global $paged;
    if ( is_home() || is_front_page() ) {
        return $paged > 1 ? esc_url( get_pagenum_link( $paged ) ) : esc_url( home_url( '/' ) );
    }

    if ( is_archive() ) {
        return esc_url( get_pagenum_link( max( 1, $paged ) ) );
    }

    return esc_url( home_url( add_query_arg( [] ) ) );
}

/**
 * Vrátí URL OG obrázku pro aktuální stránku.
 */
function jk_get_og_image_url(): string {
    // 1. Meta box přepis
    if ( is_singular() ) {
        $custom = get_post_meta( get_the_ID(), '_jk_og_image_url', true );
        if ( $custom ) {
            return esc_url( $custom );
        }
        // 2. Featured image příspěvku
        if ( has_post_thumbnail() ) {
            return esc_url( get_the_post_thumbnail_url( null, 'jk-hero' ) );
        }
    }
    // 3. Customizer výchozí OG obrázek
    $default = get_theme_mod( 'jk_og_image_url', '' );
    if ( $default ) {
        return esc_url( $default );
    }
    // 4. Silueta jako záložní OG obrázek
    return esc_url( JK_THEME_URI . '/assets/images/JK-silueta.png' );
}

/**
 * Vrátí titulek stránky pro meta / OG tagy.
 */
function jk_get_page_title_for_meta(): string {
    $custom = is_singular() ? get_post_meta( get_the_ID(), '_jk_meta_title', true ) : '';
    if ( $custom ) {
        return wp_strip_all_tags( $custom );
    }

    $parts = wp_get_document_title();
    return $parts ?: get_bloginfo( 'name' );
}

/**
 * Vrátí robots meta obsah pro aktuální stránku.
 * Vrátí prázdný řetězec, pokud nemá být žádná omezení.
 */
function jk_get_robots_meta(): string {
    // Globální noindex z Customizeru
    $global = get_theme_mod( 'jk_robots_default', 'index, follow' );

    // Noindex z meta boxu konkrétní stránky
    if ( is_singular() && get_post_meta( get_the_ID(), '_jk_noindex', true ) === '1' ) {
        return 'noindex, follow';
    }

    // Automatický noindex pro systémové stránky
    if ( is_search() || is_404() || is_date() ) {
        return 'noindex, follow';
    }

    return $global === 'index, follow' ? '' : $global;
}
