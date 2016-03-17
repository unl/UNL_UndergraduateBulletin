<?php
$url = $controller->getRawObject()::getURL();
$resource = $context->getResourceObject();
$rawController = $controller->getRawObject();
?>

<div class="wdn-band">
<div class="wdn-inner-wrapper">

<?php if (!$resource): ?>

<p>The Bulletin API gives you access to data used to build the bulletin. The following is a list of resources available.</p>
<ul>
    <?php foreach ($context->getResources() as $resource => $resourceObject): ?>
        <li><a href="<?php echo $context->getUrlForResource($resource, $rawController) ?>"><?php echo $resourceObject->title ?></a></li>
    <?php endforeach; ?>
</ul>
<h2>Format Information</h2>
<p>The following is a list of formats used in the Bulletin. The resources can be loaded in different formats using extension suffixes (<code>.json</code>, <code>.xml</code>) or if the resource requires a querystring, with a <code>format=json</code> parameter.</p>
<ul>
    <li><a href='http://www.json.org/'>JSON (JavaScript Object Notation)</a></li>
    <li><a href='http://en.wikipedia.org/wiki/XML'>XML (Extensible Markup Language)</a></li>
    <li>Partial (HTML Snippet)</li>
</ul>

<?php else: ?>

<div class="wdn-grid-set">
    <div class="bp1-wdn-col-three-fourths">
        <div class="resource">
            <h2 id="instance-uri">Resource URI</h2>
            <p><code><?php echo $resource->getUri($rawController); ?></code></p>

            <?php if (count($resource->properties)): ?>
                <h2 id="instance-properties">Resource Properties</h2>
                <table class="zentable neutral">
                    <thead>
                        <tr>
                            <th>Property</th>
                            <th>Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($resource->properties as $property): ?>
                            <tr>
                                <td><?php echo $property[0] ?></td>
                                <td><?php echo $property[1] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>

            <h2 id="instance-get-example-1">Examples</h2>
            <ul class="wdn_tabs">
                <?php foreach ($resource->formats as $format): ?>
                     <li><a href="#<?php echo $format ?>"><?php echo $format ?></a></li>
                 <?php endforeach; ?>
            </ul>
            <div class="wdn_tabs_content">
                <?php foreach ($resource->formats as $format): ?>
                    <?php
                     $resourceURI = $resource->getRawObject()->getExampleURI($rawController);
                     $formatSuffix = '.' . $format;
                     if (false !== strpos($resourceURI, '?')) {
                         $formatSuffix = '&format=' . $format;
                     }
                     ?>
                     <div id="<?php echo $format; ?>">
                        <pre><code>GET <?php echo $savvy->escape($resourceURI . $formatSuffix); ?></code></pre>
                        <h3>Response</h3>
                        <pre class="code"><code><?php echo $context->simulateRequest($resourceURI . $formatSuffix, $rawController) ?></code></pre>
                    </div>
                 <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
<script>
    require(['jquery', 'https://cdn.jsdelivr.net/highlight.js/9.2.0/highlight.min.js'], function($, hljs) {
        $('.resource pre.code code').each(function() {
            hljs.highlightBlock(this);
        })
    })
</script>

<?php endif; ?>

</div>
</div>
