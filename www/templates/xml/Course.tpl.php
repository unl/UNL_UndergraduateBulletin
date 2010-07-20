<?php
echo str_replace('<?xml version="1.0"?>', '', $context->getRawObject()->asXML());