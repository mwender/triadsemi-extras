<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* pricing-table.twig */
class __TwigTemplate_849f3ca3f1c734e741df89671aaa20500bf365c352cd070c34bc542941973074 extends \Twig\Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 1
        if ( !twig_test_empty(($context["bulk_discounts"] ?? null))) {
            // line 2
            echo "  <table class=\"table table-sm table-striped table-discounts\">
    <thead>
      <tr>
        <th style=\"font-size: 14px;\">Price Break</th>
        <th style=\"font-size: 14px;\">Unit Price</th>
        <th style=\"text-align: right; font-size: 14px;\">Extended Price</th>
      </tr>
    </thead>
    <tbody>
    ";
            // line 11
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["bulk_discounts"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["discount"]) {
                // line 12
                echo "      ";
                $context["unitprice"] = (($context["baseprice"] ?? null) - twig_get_attribute($this->env, $this->source, $context["discount"], "discount", [], "any", false, false, false, 12));
                // line 13
                echo "      <tr>
        <td>";
                // line 14
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["discount"], "quantity", [], "any", false, false, false, 14), "html", null, true);
                echo "+</td>
        <td>";
                // line 15
                echo twig_escape_filter($this->env, twig_number_format_filter($this->env, ($context["unitprice"] ?? null), 2), "html", null, true);
                echo "</td>
        <td style=\"text-align: right;\">\$";
                // line 16
                echo twig_escape_filter($this->env, twig_number_format_filter($this->env, (twig_get_attribute($this->env, $this->source, $context["discount"], "quantity", [], "any", false, false, false, 16) * ($context["unitprice"] ?? null)), 2), "html", null, true);
                echo "</td>
      </tr>
    ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['discount'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 19
            echo "    </tbody>
  </table>
";
        }
    }

    public function getTemplateName()
    {
        return "pricing-table.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  77 => 19,  68 => 16,  64 => 15,  60 => 14,  57 => 13,  54 => 12,  50 => 11,  39 => 2,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "pricing-table.twig", "/Users/mwender/webdev/local-lightning/triadsemi.com/app/public/wp-content/plugins/triadsemi-extras/lib/templates/twig/pricing-table.twig");
    }
}
