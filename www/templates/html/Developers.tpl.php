<style type="text/css">
    blockquote {
         background: none repeat scroll 0pt 0pt rgb(240, 240, 240);
         margin: 15px 0pt;
         padding: 10px;
         width: auto;
         word-wrap: break-word;
    }
    
    blockquote > p {
         clear: none;
         margin: 0pt;
         padding: 0pt;
    }
    
    div.resource {
         border-bottom: #F0F0F0 5px solid;
         margin-bottom: 20px;
    }
    
    #maincontent div.resource > ul {
        padding-left:0;
    }

    div.resource > ul > li {
        list-style:none;
    }

    a.resources 
    {
        float:right;
        font-size:12px
    }
</style>

<script type="text/javascript">jQuery = $ = WDN.jQuery;</script>

<script type="text/javascript" src="<?php echo UNL_UndergraduateBulletin_Controller::getBaseURL()?>templates/html/scripts/jquery.beautyOfCode.js"></script>

<script type="text/javascript">
    $.beautyOfCode.init({
        theme: "RDark",
        brushes: ['Xml', 'JScript', 'CSharp', 'Plain', 'Php', "Java", "JavaFX"],
        defaults: {'wrap-lines':false},
        ready: function() {
            $.beautyOfCode.beautifyAll();

        }
    });
</script>
<div class="wdn-grid-set">
    <div class="bp1-wdn-col-three-fourths">
        
        <?php
            $resource = "UNL_UndergraduateBulletin_Developers_" . $context->resource;
            $resource = new $resource;
            ?>
            <div class="resource">
            <h1 id="instance" class="sec_main"><?php echo $resource->title; ?> Resource</h1>
            <h3>Details</h3>
            <ul>
                <li>
                    <h4 id="instance-uri"><a href="#instance-uri">Resource URI</a></h4>
                    <blockquote>
                        <p><?php echo $resource->uri; ?></p>
                    </blockquote>
                </li>
                <?php if (count($resource->properties)): ?>
                <li>
                    <h4 id="instance-properties"><a href="#instance-properties">Resource Properties</a></h4> 
                    <table class="zentable neutral">
                    <thead><tr><th>Property</th><th>Description</th><th>JSON</th><th>XML</th></tr></thead>
                      <tbody>
                      <?php 
                        foreach ($resource->properties as $property) {
                          echo "<tr>
                                    <td>$property[0]</td>
                                    <td>$property[1]</td>
                                    <td>$property[2]</td>
                                    <td>$property[3]</td>
                                </tr>";
                        }
                      ?>
                      </tbody>
                    </table>
                </li>
                <?php endif; ?>
                <li>
                    <h4 id="instance-get"><a href="#instance-get">HTTP GET</a></h4>
                    <p>Returns a representation of the resource, including the properties above.</p>
                </li>
                <li>
                    <h4 id="instance-get-example-1"><a href="#instance-get-example-1">Example</a></h4>
                    <ul class="wdn_tabs">
                    <?php 
                     foreach ($resource->formats as $format) {
                         echo "<li><a href='#$format'>$format</a></li>";
                     }
                    ?>
                    </ul>
                    <div class="wdn_tabs_content" >
                         <?php 
                         foreach ($resource->formats as $format) {
                             $resourceURI = $resource->exampleURI;
                             if (false === strpos($resourceURI, '?')) {
                                 $resourceURI .= '?format='.$format;
                             } else {
                                 $resourceURI .= '&format='.$format;
                             }
                             ?>
                             <div id="<?php echo $format; ?>">
                                <ul>
                                    <li>
                                        Calling this:
                                        <blockquote>
                                            <p>GET <?php echo $resourceURI; ?></p>
                                        </blockquote>
                                    </li>
                                    <li>
                                        Provides this:
                                        <?php
                                        if (substr($resourceURI, 0, 4) != 'http') {
                                            $resourceURI = 'http://localhost' . $resourceURI;
                                        }
                                        
                                        //Get the output.
                                        if (!$result = file_get_contents($resourceURI)) {
                                            $result = "Error getting file contents.";
                                        }
                                        switch($format) {
                                            case "json":
                                                $result = UNL_UndergraduateBulletin_Developers::formatJSON($result);
                                                $code = 'javascript';
                                                break;
                                            case "xml":
                                                $code = "xml";
                                                break;
                                            default:
                                                $code = "html";
                                        }
                                        ?>
                                        <pre class="code">
                                            <code class="<?php echo $code; ?>"><?php echo htmlentities($result); ?></code>
                                        </pre>
                                    </li>
                                </ul>
                            </div>
                             <?php
                         }
                         ?>
                        
                    </div>
                </li>
            </ul>
        </div>
        
    </div>
    <div class="bp1-wdn-col-one-fourth">
        <div id='resources' class="zenbox primary">
            <h3>UNL Undergraduate Bulletin API</h3>
            <p>The following is a list of resources for the Undergraduate Bulletin.</p>
            <ul>
                <?php 
                foreach ($context->resources as $resource) {
                    $resource_url = UNL_UndergraduateBulletin_Controller::getURL().'developers?resource='.$resource;
                    echo "<li><a href='$resource_url'>$resource</a></li>";
                }
                ?>
            </ul>
        </div>
        <div class="zenbox neutral">
            <h3>Format Information</h3>
            <p>The following is a list of formats used in the Undergraduate Bulletin.</p>
            <ul>
                <li><a href='http://www.json.org/'>JSON (JavaScript Object Notation)</a></li>
                <li><a href='http://en.wikipedia.org/wiki/XML'>XML (Extensible Markup Language)</a></li>
                <li>Partial - The un-themed main content area of the page.</li>
            </ul>
        </div>
    </div>
</div>