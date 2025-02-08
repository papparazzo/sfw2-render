# sfw2-render

Enables redering web-content on condition
(see https://developer.mozilla.org/en-US/docs/Web/HTTP/Content_negotiation for further information)

## How to use it

First, set up a render-object and specify the conditions:

```php

use Handlebars\Handlebars;
use SFW2\Render\Conditions\IsAjaxRequest;
use SFW2\Render\Conditions\MatchesPath;
use SFW2\Render\RenderJson;
use SFW2\Render\RenderOnConditions;
   
// Have a look at salesforce/handlebars-php for the proper use   
$handlebars = new Handlebars([
    "loader" => StringLoader(),
]);
                
$render = new RenderOnConditions();

// Checks, if "X-Requested-With" header line is set and, if so, render data in json-format
$render->addEngine(new IsAjaxRequest(), new RenderJson());

// Checks, if certain request-path is set and, if so, render data in xml-format.
$render->addEngine(new MatchesPath('/'), new RenderJson($handlebars));

// Render other stuff in html-format
$render->addEngine(new AlwaysTrue(),  new RenderHtml($handlebars, '<html>{{content}}</html>'));
```

use the prebuild render in your controller/action-class to render your response-content on the
previous declared conditions

```php

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use SFW2\Render\RenderInterface;

class MyController{
  
    public function __construct(
        private RenderInterface $render
    ) {
    }
    
    public function myAction(RequestInterface $request, ResponseInterface $response, array $data): ResponseInterface
    {
        return $this->render->render($request, $response, [], 'mytemplate.handlebars');
    }
}

```