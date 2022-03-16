#Testing

## Description
This package provides some testing utils


## install 
```bash
composer require --dev planb/planb
```
##Mock a final class
In phpunit.xml.dist
```xml
<extensions>
    <extension class="PlanB\Testing\PhpUnit\Hook\BypassFinalHook"/>
</extensions>
```