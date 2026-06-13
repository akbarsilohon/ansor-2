jQuery( document ).ready( function( $ ){

    // Ganti logo website =================
    let brandAnsor;
    $( '#ganti_brand' ).on( 'click', function( e ){
        e.preventDefault();

        if( brandAnsor ){
            brandAnsor.open();
            return;
        }

        brandAnsor = wp.media({
            title: 'Ganti Logo Website',
            button: {
                text: 'Gunakan Gambar'
            },
            multiple: false
        });

        brandAnsor.on( 'select', function(){
            const attachment = brandAnsor.state().get( 'selection' ).first().toJSON();
            $( '#input_brand_ansor').val( attachment.url );
            $( 'img#brand_ansor' ).attr( 'src', attachment.url );
        });

        brandAnsor.open();
    });

    // Reset logo ke default ================
    $( '#reset_brand').on( 'click', function(){
        $( 'img#brand_ansor').attr( 'src', defaultBrand );
        $( '#input_brand_ansor' ).val( defaultBrand );
    });


    // Hero Image =====================
    let HeroAnsor;
    $( '#ganti_hero').on( 'click', function( e ){

        e.preventDefault();

        if( HeroAnsor ){
            HeroAnsor.open();
            return;
        }

        HeroAnsor = wp.media({
            title: 'Ganti Gambar Hero Home Page',
            button: {
                text: 'Gunakan Gambar'
            },
            multiple: false
        });

        HeroAnsor.on( 'select', function(){
            const attachment = HeroAnsor.state().get('selection').first().toJSON();
            $('img#ansor_hero_home').attr( 'src', attachment.url );
            $('#input_ansor_hero_home').val( attachment.url );
        });

        HeroAnsor.open();
    });

    // Reset Default Hero Image ============
    $( '#reset_hero').on('click', function(){
        $('img#ansor_hero_home').attr( 'src', defaultHeroImage );
        $('#input_ansor_hero_home').val( defaultHeroImage );
    });
});