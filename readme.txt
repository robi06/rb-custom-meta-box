# notice






todo

 - page creation with shortcodes

   check if page exist/not

 - page selection for basic url rewrite ( agency/{something}/edit }
 - user role define + permission .
 - front end permission managements
 - owner check .

 - templates,loops,hooks



[ view bonho kore rakhte hobe css dia ]




create page list :
 - registration [ page creation with shortcode ]
 - login  [ page creation with shortcode ]
 - agency
    - agency/{agency_name}       dynamic
    - agency/{agency_name}/edit  dynamic
    - agency/agents
 - agents
    - agents/{name}
    - agents/{name}/edit

       // assigned company : list
       // agents - company

 - company
    - company/{name}
    - company/{name}/edit

 -job [list]
  -job/{job_id}
    





shortcode Listing
  - login ( agency , company , candidate , agents ) , registratoin ( anency , comany ) ,job listing , candidate listing , 

  - candidate registration ( linkdin , xio , )






        - add company
        - all agents listing /agency/agency-name/agents/
        - create job

- agents dashboard





1. show agent profile
2. add company from agency_admin profile
3. assign agent to the company










page creation :
---------------
// shortcode creation
register
login
job list
candidate list



virtual
--------
agency/{agency_name}/dash




































process :

1 . load all the pages with necessary shortcodes .
2 . applied rewrite rules on them .
3 . settings panel page selection then will change the page id in the router
4 . user role and cap
5 .













need to solve problem :
1 . agency/{id}
2 . agency/{id}/{edit}
3 . agency/



problem :

1 . should page dependent
      - track the page in better style
      - do the shortcode and another data with it
      - better for wp routing
2 . shortcode support







todo :


1 . notice with start and create page . then do 2

2. force page creation with fixed shortcode
 + automatic select page with it .

  apply rewrite rule
      for - /agency

2.














----------
page list
----------

- registration
- login
- forget password

profile/
- profile

agency/all
    - all the agency
agency/agency-name
    - agency details

agency/agency-name/edit  [ here need some premission ]
    - edit page

agency/agency-name/agents


agency/agency-name/agents/id
agency/agency-name/agents/id/edit


company/all
    - all the company

company/


page with defined page template . will built this manually

page with page template.








snippets:


    public function tareq_shortcode( $atts = array() ){

        ob_start();

        $template_names = array(

            "fol/tareq.php",
        );

        // Prepend custom templates.
        if ( ! empty( $args['template'] ) ) {
            $add_templates = array_filter( (array) $args['template'] );
            $template_names = array_merge( $add_templates, $template_names );
        }

        $template_loader = new Uou_Careers_Load_Template();
        $template = $template_loader->locate_template( $template_names );

        echo '<div class="cue-playlist-container">';




        include( $template );



        echo '</div>';



        return ob_get_clean();

    }