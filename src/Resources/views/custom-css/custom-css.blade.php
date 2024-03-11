{{-- Blog Page Start --}}
<style>
    .grid-wrap{
        margin: 0 -10px;
    }
    .column-9{
        width: 75%;
        padding:0 10px;
    }
    .column-3{
        width: 25%;
        padding:0 10px;
    }
    .blog-grid-list{
        margin: 0 -10px;
    }
    .blog-post-item{
        width: 33.33%;
        padding: 0 10px;
        margin-bottom: 20px;
    }
    .related-blog-post-item{
        width: 25%;
        padding: 0 10px;
        margin-bottom: 20px;
    }
    .blog-post-box{
        border: 1px solid rgba(0,0,0,.125);  
        padding: 15px;
        border-radius: 10px;
        height: 100%;
    }
    .blog-post-box .card-text{
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
    }
    .blog-post-box .post-meta{
        font-size: 13px;
        color: #8d8d8d;
        margin-bottom: 6px;
    }
    .blog-grid-img{
        overflow: hidden;
        position: relative;
        margin-bottom: 20px;
    }
    .blog-grid-img:before{
        content: '';
        padding-top: 65%;
        display: block;
    }
    .blog-grid-img img{
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .blog-post-item .card-title{
        font-size: 20px;
        line-height: 1.2;
        margin-bottom: 20px;
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }

    .blog-post-item .card-footer,
    .related-blog-post-item .card-footer{
        margin-top: 20px;
    }
    .blog-post-item .card-footer a,
    .related-blog-post-item .card-footer a{
        font-weight: 600;
    }
    .blog-post-item .card-title:hover,
    .blog-post-item .card-footer a:hover,
    .related-blog-post-item .card-title:hover,
    .related-blog-post-item .card-footer a:hover{
        color: #fbc256;
    }
    .blog-sidebar .categories{
        padding-left: 20px;
    }
    .blog-sidebar .categories h3{
        font-size: 20px;
        line-height: 1.2;
        margin-bottom: 15px;
    }
    .blog-sidebar .categories .list-group{
        border: 1px solid rgba(0,0,0,.125);  
        border-radius: 10px;
    }

    .blog-sidebar .categories .list-group li{
        border-top: 1px solid rgba(0,0,0,.125); 
    }
    .blog-sidebar .categories .list-group li:first-child{
        border-top: 0;
    }
    .blog-sidebar .categories .list-group li a{
        padding: 9px 15px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-size: 15px;
    }
    .blog-sidebar .categories .list-group li a .badge-primary{
        background: #4d7ea8;
        border-radius: 30px;
        color: #fff;
        font-size: 13px;
        padding: 2px 10px;

    }
    .pagination{
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }
    .pagination a{
        width: 30px;
        height: 30px;
        border: 1px solid #4d7ea8;
        color: #000;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .pagination a:hover,
    .pagination a.active{
        background: #4d7ea8;
        color: #fff;
    }
    .pagination a.previous:before{
        content: '<<';
        letter-spacing: -4px;
    }
    .pagination a.previous .icon,
    .pagination a.next .icon{
        display: none;
    }
    .pagination a.next:before{
        content: '>>';
        letter-spacing: -4px;
    }
    .page-title{
        font-size: 22px;
    }
    .tags-part{
        margin-top: 30px;
    }
    .tags-part .tag-list{
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }
    .tags-part .tag-list a{
        background-color: #4d7ea8;
        border-radius: 5px;
        color: #fff;
        font-size: 14px;
        display: flex;
        align-items: center;
        padding: 3px 10px;
        gap:5px;
    }
    .tags-part .tag-list a .badge-light{
        background: #fff;
        border-radius: 5px;
        padding: 2px 6px;
        font-size: 13px;
        color: #000;
        line-height: 1;
    }
    .post-categories .cat-link {
        background: rgba(0,0,0,.05);
        padding: 3px 10px;
        font-size: 14px;
        margin-right: 5px;
        margin-bottom: 5px;
        border-radius: 4px;
        display: inline-block;
        color: #333;
    }

    .post-categories .cat-link:hover {
        background: #4d7ea8;
        color: #fff;
    }

    .blog-post-box .post-meta a {
        color: #4d7ea8;
    }

    .blog-post-box .post-meta a:hover {
        text-decoration: underline;
    }

    .post-not-available{
        text-align: center!important;
        color: #0c5460;
        background-color: #d1ecf1;
        border-color: #bee5eb;
        position: relative;
        padding: 0.75rem 1.25rem;
        border: 1px solid transparent;
        border-radius: 10px;
        margin: 10px 0px 10px 0px;
    }

    @media all and (max-width: 1180px){
        .blog-sidebar .categories {
            padding-left: 0px;
        }

    }

    @media all and (max-width: 1024px){
        .column-3,
        .column-9,
        .column-12 {
            width: 100%;
            padding: 0 10px;
        }
        .blog-post-item, .related-blog-post-item {
            width: 50%;
            padding: 0 10px;
            margin-bottom: 20px;
        }

    }

    @media all and (max-width: 767px){
        .blog-hero-image .hero-main-title{
            font-size: 1.5rem;
        }
        .blog-hero-image{
            height: 270px;
            margin-bottom: 30px;
        }
        .container {
            width: 100%;
            margin-right: auto;
            margin-left: auto;
            padding-right: 20px;
            padding-left: 20px;
        }
        .page-title {
            font-size: 22px;
            margin-bottom: 15px;
        }
        .comment-part .column-6 {
            width: 100%;
            padding: 0 10px;
        }
        .blog-post-item, .related-blog-post-item {
            width: 100%;
            padding: 0 10px;
            margin-bottom: 20px;
        }
    }

    /*Blog Page End*/

    /*Blog Single Page Start*/

    .grid-wrap{
        margin: 0 -10px;
    }
    .column-12{
        width: 100%;
        padding:0 10px;
    }
    .column-9{
        width: 75%;
        padding:0 10px;
    }
    .column-6{
        width: 50%;
        padding:0 10px;
    }
    .column-3{
        width: 25%;
        padding:0 10px;
    }
    .blog-sidebar .categories{
        padding-left: 20px;
    }
    .blog-sidebar .categories h3{
        font-size: 20px;
        line-height: 1.2;
        margin-bottom: 15px;
    }
    .blog-sidebar .categories .list-group{
        border: 1px solid rgba(0,0,0,.125);  
        border-radius: 10px;
    }

    .blog-sidebar .categories .list-group li{
        border-top: 1px solid rgba(0,0,0,.125); 
    }
    .blog-sidebar .categories .list-group li:first-child{
        border-top: 0;
    }
    .blog-sidebar .categories .list-group li a{
        padding: 9px 15px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-size: 15px;
    }
    .blog-sidebar .categories .list-group li a .badge-primary{
        background: #4d7ea8;
        border-radius: 30px;
        color: #fff;
        font-size: 13px;
        padding: 2px 10px;

    }

    .page-title{
        font-size: 26px;
        margin-bottom: 20px;
    }
    .blog-hero-image {
        height: 450px;
        margin-bottom: 40px;
        position: relative;
    }
    .blog-hero-image img{
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
    }
    .blog-hero-image .hero-main-title{
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
        text-align: center;
        width: 100%;
        max-width: 700px;
        background: rgba(0,0,0,.5);
        padding: 10px;
        color: #fff;
        font-size: 2.5rem;
        margin: 0;
        line-height: 1;
    }

    .tags-part{
        margin-top: 30px;
    }
    .tags-part .tag-list{
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }
    .tags-part .tag-list a{
        background-color: #4d7ea8;
        border-radius: 5px;
        color: #fff;
        font-size: 14px;
        display: flex;
        align-items: center;
        padding: 3px 10px;
        gap:5px;
    }
    .tags-part .tag-list a .badge-light{
        background: #fff;
        border-radius: 5px;
        padding: 2px 6px;
        font-size: 13px;
        color: #000;
        line-height: 1;
    }

    .comment-form-holder{
        margin-top: 1rem!important;
    }
    .comment-form-holder .form-row {
        display: -ms-flexbox;
        display: flex;
        -ms-flex-wrap: wrap;
        flex-wrap: wrap;
        margin-right: -10px;
        margin-left: -10px;
    }
    .comment-part h3{
        margin-bottom: 5px;
        color: #000;
    }
    .comment-part .form-row>.col, .comment-part .form-row>[class*=col-] {
        padding-right: 5px;
        padding-left: 5px;
    }
    .comment-part .mb-3, .comment-part .my-3 {
        margin-bottom: 1rem!important;
    }
    .comment-part .mr-3, .comment-part .mx-3 {
        margin-right: 1rem!important;
    }
    .comment-part .input-group {
        position: relative;
        display: -ms-flexbox;
        display: flex;
        -ms-flex-wrap: wrap;
        flex-wrap: wrap;
        -ms-flex-align: stretch;
        align-items: stretch;
        width: 100%;
    }
    .comment-part .input-group-append, .comment-part .input-group-prepend {
        display: -ms-flexbox;
        display: flex;
    }
    .comment-part .input-group-prepend {
        margin-right: -3px;
    }
    .comment-part .input-group-text {
        display: -ms-flexbox;
        display: flex;
        -ms-flex-align: center;
        align-items: center;
        padding: 0.375rem 0.75rem;
        margin-bottom: 0;
        font-size: 1rem;
        font-weight: 400;
        line-height: 1.5;
        color: #495057;
        text-align: center;
        white-space: nowrap;
        background-color: #e9ecef;
        border: 1px solid #ced4da;
        border-radius: 0.25rem;
    }
    .comment-part .form-control {
        height: 100%;
        font-size: 14px;
        padding: 6px 12px;
    }
    .comment-part .form-control {
        display: block;
        width: 100%;
        padding: 0.375rem 0.75rem;
        font-size: 1rem;
        font-weight: 400;
        line-height: 1.5;
        color: #495057;
        background-color: #fff;
        background-clip: padding-box;
        border: 1px solid #ced4da;
        border-radius: 0.25rem;
        transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
    }
    .comment-part .text-right {
        text-align: right!important;
    }
    .comment-part .btn {
        display: inline-block;
        font-weight: 400;
        color: #212529;
        text-align: center;
        vertical-align: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        background-color: transparent;
        border: 1px solid transparent;
        padding: 0.375rem 0.75rem;
        font-size: 1rem;
        line-height: 1.5;
        border-radius: 0.25rem;
        transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;
    }
    .comment-part .btn-group-lg>.btn, .comment-part .btn-lg {
        padding: 0.5rem 1rem;
        font-size: 0.7rem;
        line-height: 1;
        border-radius: 0.3rem;
    }
    .comment-part .btn-primary {
        color: #fff;
        background-color: #4d7ea8;
        border-color: #4d7ea8;
    }
    .comment-part .form-group {
        margin-bottom: 1rem;
    }
    .related-bolg-part, .comment-part .comment-form {
        border-bottom: 1px solid #D6D6D6;
        margin-bottom: 20px;
        padding-bottom: 10px;
    }
    .related-bolg-part {
        border-top: 1px solid #D6D6D6;
        margin-top: 20px;
        padding-top: 10px;
    }
    .comment-part .media {
        margin-top: 15px !important;
    }
    .comment-part .media {
        display: -ms-flexbox;
        display: flex;
        -ms-flex-align: start;
        align-items: flex-start;
    }
    .comment-part .rounded-circle {
        border-radius: 50%!important;
    }
    .comment-part .media-body {
        -ms-flex: 1;
        flex: 1;
        font-size: 14px;
        color:#6e6e6e;
    }
    .comment-part .media-body .comment{
        margin: 5px 0;
    }
    .comment-part .comment_name {
        font-weight: bold;
        color:#000;
    }
    .comment-part .comment_created {
        margin-left: 5px;
        font-style: italic;
    }
    .comment-part .btn-danger, .comment-part .btn-danger:active:focus, .comment-part .btn-danger:active:hover, .comment-part .btn-danger:focus, .comment-part .btn-danger:hover {
        background: #f05153;
        border-color: #f05153;
        color:#fff;
    }
    .comment-part .input-group .form-control{
        position: relative;
        -ms-flex: 1 1 auto;
        flex: 1 1 auto;
        width: 1%;
        margin-bottom: 0;
    }
    .comment-part .input-group>.custom-select:not(:first-child), .comment-part .input-group>.form-control:not(:first-child) {
        border-top-left-radius: 0;
        border-bottom-left-radius: 0;
    }
    .post-tags .post-tag-lists a {
        background: rgba(0,0,0,.05);
        padding: 3px 10px;
        font-size: 14px;
        margin-left: 5px;
        margin-bottom: 5px;
        border-radius: 4px;
        display: inline-block;
        color: #333;
    }
    .post-tags{
        display: flex;
    }
    .post-tags .post-tag-lists a:hover {
        background: #4d7ea8;
        color: #fff;
    }
    .comment-not-allow{
        text-align: center!important;
        color: #856404;
        background-color: #fff3cd;
        border-color: #ffeeba;
        position: relative;
        padding: 0.75rem 1.25rem;
        border: 1px solid transparent;
        border-radius: 10px;
    }
    .comment-not-allow-guest{
        text-align: center!important;
        color: #0c5460;
        background-color: #d1ecf1;
        border-color: #bee5eb;
        position: relative;
        padding: 0.75rem 1.25rem;
        border: 1px solid transparent;
        border-radius: 10px;
        margin: 10px 0px 10px 0px;
    }
    .comment-not-allow-guest a{
        color: #007bff;
        text-decoration: none;
        background-color: transparent;
    }

    @media all and (max-width: 1180px){
        .blog-sidebar .categories {
            padding-left: 0px;
        }

    }

    @media all and (max-width: 1024px){
        .column-3,
        .column-9 {
            width: 100%;
            padding: 0 10px;
        }

    }
    @media all and (max-width: 767px){
        .blog-hero-image .hero-main-title{
            font-size: 1.5rem;
        }
        .blog-hero-image{
            height: 270px;
            margin-bottom: 30px;
        }
        .container {
            width: 100%;
            margin-right: auto;
            margin-left: auto;
            padding-right: 20px;
            padding-left: 20px;
        }
        .page-title {
            font-size: 22px;
            margin-bottom: 15px;
        }
        .comment-part .column-6 {
            width: 100%;
            padding: 0 10px;
        }
    }

    /*Blog Single Page End*/

    /*Blog Category Page Start*/

    .grid-wrap{
        margin: 0 -10px;
    }
    .column-12{
        width: 100%;
        padding:0 10px;
    }
    .column-9{
        width: 75%;
        padding:0 10px;
    }
    .column-3{
        width: 25%;
        padding:0 10px;
    }
    .blog-grid-list{
        margin: 0 -10px;
    }
    .blog-post-item{
        width: 33.33%;
        padding: 0 10px;
        margin-bottom: 20px;
    }
    .blog-post-box{
        border: 1px solid rgba(0,0,0,.125);  
        padding: 15px;
        border-radius: 10px;
        height: 100%;
    }
    .blog-post-box .card-text{
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
    }
    .blog-post-box .post-meta{
        font-size: 13px;
        color: #8d8d8d;
        margin-bottom: 10px;
    }
    .blog-grid-img{
        overflow: hidden;
        position: relative;
        margin-bottom: 20px;
    }
    .blog-grid-img:before{
        content: '';
        padding-top: 65%;
        display: block;
    }
    .blog-grid-img img{
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .blog-post-item .card-title{
        font-size: 20px;
        line-height: 1.2;
        margin-bottom: 20px;
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }

    .blog-post-item .card-footer{
        margin-top: 20px;
    }
    .blog-post-item .card-footer a{
        font-weight: 600;
    }
    .blog-post-item .card-title:hover,
    .blog-post-item .card-footer a:hover{
        color: #fbc256;
    }
    .blog-sidebar .categories{
        padding-left: 20px;
    }
    .blog-sidebar .categories h3{
        font-size: 20px;
        line-height: 1.2;
        margin-bottom: 15px;
    }
    .blog-sidebar .categories .list-group{
        border: 1px solid rgba(0,0,0,.125);  
        border-radius: 10px;
    }

    .blog-sidebar .categories .list-group li{
        border-top: 1px solid rgba(0,0,0,.125); 
    }
    .blog-sidebar .categories .list-group li a:hover{
        background-color: rgba(0,0,0,.05); 
    }
    .blog-sidebar .categories .list-group li:first-child{
        border-top: 0;
    }
    .blog-sidebar .categories .list-group li a{
        padding: 9px 15px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-size: 15px;
    }
    .blog-sidebar .categories .list-group li a .badge-primary{
        background: #4d7ea8;
        border-radius: 30px;
        color: #fff;
        font-size: 13px;
        padding: 2px 10px;

    }
    .pagination{
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }
    .pagination a{
        width: 30px;
        height: 30px;
        border: 1px solid #4d7ea8;
        color: #000;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .pagination a:hover,
    .pagination a.active{
        background: #4d7ea8;
        color: #fff;
    }
    .pagination a.previous:before{
        content: '<<';
        letter-spacing: -4px;
    }
    .pagination a.previous .icon,
    .pagination a.next .icon{
        display: none;
    }
    .pagination a.next:before{
        content: '>>';
        letter-spacing: -4px;
    }
    .page-title{
        font-size: 22px;
    }
    .blog-hero-image {
        height: 450px;
        margin-bottom: 40px;
    }
    .blog-hero-image img{
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
    }

    .blog-hero-image {
        height: 450px;
        margin-bottom: 40px;
        position: relative;
    }
    .blog-hero-image img{
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
    }
    .blog-hero-image .hero-main-title{
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
        text-align: center;
        width: 100%;
        max-width: 700px;
        background: rgba(0,0,0,.5);
        padding: 10px;
        color: #fff;
        font-size: 2.5rem;
        margin: 0;
        line-height: 1;
    }

    .blog-post-content {
        line-height: 1.5;
        font-size: 16px;
        margin-bottom: 30px;
    }

    .text-justify {
        text-align: justify!important;
    }

    .tags-part{
        margin-top: 30px;
    }
    .tags-part .tag-list{
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }
    .tags-part .tag-list a{
        background-color: #4d7ea8;
        border-radius: 5px;
        color: #fff;
        font-size: 14px;
        display: flex;
        align-items: center;
        padding: 3px 10px;
        gap:5px;
    }
    .tags-part .tag-list a .badge-light{
        background: #fff;
        border-radius: 5px;
        padding: 2px 6px;
        font-size: 13px;
        color: #000;
        line-height: 1;
    }

    @media all and (max-width: 1180px){
        .blog-sidebar .categories {
            padding-left: 0px;
        }

    }

    @media all and (max-width: 1024px){
        .column-3,
        .column-9 {
            width: 100%;
            padding: 0 10px;
        }
        .blog-post-item {
            width: 50%;
            padding: 0 10px;
            margin-bottom: 20px;
        }

    }
    @media all and (max-width: 767px){
        .blog-hero-image .hero-main-title{
            font-size: 1.5rem;
        }
        .blog-hero-image{
            height: 270px;
            margin-bottom: 30px;
        }
        .container {
            width: 100%;
            margin-right: auto;
            margin-left: auto;
            padding-right: 20px;
            padding-left: 20px;
        }
        .page-title {
            font-size: 22px;
            margin-bottom: 15px;
        }
        .comment-part .column-6 {
            width: 100%;
            padding: 0 10px;
        }
        .blog-post-item {
            width: 100%;
            padding: 0 10px;
            margin-bottom: 20px;
        }
    }

    /*Blog Category Page End*/

    /*Blog Tag Page Start*/

    .grid-wrap{
        margin: 0 -10px;
    }
    .column-12{
        width: 100%;
        padding:0 10px;
    }
    .column-9{
        width: 75%;
        padding:0 10px;
    }
    .column-3{
        width: 25%;
        padding:0 10px;
    }
    .blog-grid-list{
        margin: 0 -10px;
    }
    .blog-post-item{
        width: 33.33%;
        padding: 0 10px;
        margin-bottom: 20px;
    }
    .blog-post-box{
        border: 1px solid rgba(0,0,0,.125);  
        padding: 15px;
        border-radius: 10px;
        height: 100%;
    }
    .blog-post-box .card-text{
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
    }
    .blog-post-box .post-meta{
        font-size: 13px;
        color: #8d8d8d;
        margin-bottom: 10px;
    }
    .blog-grid-img{
        overflow: hidden;
        position: relative;
        margin-bottom: 20px;
    }
    .blog-grid-img:before{
        content: '';
        padding-top: 65%;
        display: block;
    }
    .blog-grid-img img{
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .blog-post-item .card-title{
        font-size: 20px;
        line-height: 1.2;
        margin-bottom: 20px;
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }

    .blog-post-item .card-footer{
        margin-top: 20px;
    }
    .blog-post-item .card-footer a{
        font-weight: 600;
    }
    .blog-post-item .card-title:hover,
    .blog-post-item .card-footer a:hover{
        color: #fbc256;
    }
    .blog-sidebar .categories{
        padding-left: 20px;
    }
    .blog-sidebar .categories h3{
        font-size: 20px;
        line-height: 1.2;
        margin-bottom: 15px;
    }
    .blog-sidebar .categories .list-group{
        border: 1px solid rgba(0,0,0,.125);  
        border-radius: 10px;
    }

    .blog-sidebar .categories .list-group li{
        border-top: 1px solid rgba(0,0,0,.125); 
    }
    .blog-sidebar .categories .list-group li:first-child{
        border-top: 0;
    }
    .blog-sidebar .categories .list-group li a{
        padding: 9px 15px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-size: 15px;
    }
    .blog-sidebar .categories .list-group li a .badge-primary{
        background: #4d7ea8;
        border-radius: 30px;
        color: #fff;
        font-size: 13px;
        padding: 2px 10px;

    }
    .pagination{
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }
    .pagination a{
        width: 30px;
        height: 30px;
        border: 1px solid #4d7ea8;
        color: #000;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .pagination a:hover,
    .pagination a.active{
        background: #4d7ea8;
        color: #fff;
    }
    .pagination a.previous:before{
        content: '<<';
        letter-spacing: -4px;
    }
    .pagination a.previous .icon,
    .pagination a.next .icon{
        display: none;
    }
    .pagination a.next:before{
        content: '>>';
        letter-spacing: -4px;
    }
    .page-title{
        font-size: 22px;
    }
    .blog-hero-image {
        height: 450px;
        margin-bottom: 40px;
    }
    .blog-hero-image img{
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
    }

    .blog-hero-image {
        height: 450px;
        margin-bottom: 40px;
        position: relative;
    }
    .blog-hero-image img{
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
    }
    .blog-hero-image .hero-main-title{
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
        text-align: center;
        width: 100%;
        max-width: 700px;
        background: rgba(0,0,0,.5);
        padding: 10px;
        color: #fff;
        font-size: 2.5rem;
        margin: 0;
        line-height: 1;
    }

    .blog-post-content {
        line-height: 1.5;
        font-size: 16px;
        margin-bottom: 30px;
    }

    .text-justify {
        text-align: justify!important;
    }

    .tags-part{
        margin-top: 30px;
    }
    .tags-part .tag-list{
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }
    .tags-part .tag-list a{
        background-color: #4d7ea8;
        border-radius: 5px;
        color: #fff;
        font-size: 14px;
        display: flex;
        align-items: center;
        padding: 3px 10px;
        gap:5px;
    }
    .tags-part .tag-list a .badge-light{
        background: #fff;
        border-radius: 5px;
        padding: 2px 6px;
        font-size: 13px;
        color: #000;
        line-height: 1;
    }

    @media all and (max-width: 1180px){
        .blog-sidebar .categories {
            padding-left: 0px;
        }

    }

    @media all and (max-width: 1024px){
        .column-3,
        .column-9 {
            width: 100%;
            padding: 0 10px;
        }
        .blog-post-item {
            width: 50%;
            padding: 0 10px;
            margin-bottom: 20px;
        }

    }
    @media all and (max-width: 767px){
        .blog-hero-image .hero-main-title{
            font-size: 1.5rem;
        }
        .blog-hero-image{
            height: 270px;
            margin-bottom: 30px;
        }
        .container {
            width: 100%;
            margin-right: auto;
            margin-left: auto;
            padding-right: 20px;
            padding-left: 20px;
        }
        .page-title {
            font-size: 22px;
            margin-bottom: 15px;
        }
        .comment-part .column-6 {
            width: 100%;
            padding: 0 10px;
        }
        .blog-post-item {
            width: 100%;
            padding: 0 10px;
            margin-bottom: 20px;
        }
    }
    
    /*Blog Tag Page End*/

</style>