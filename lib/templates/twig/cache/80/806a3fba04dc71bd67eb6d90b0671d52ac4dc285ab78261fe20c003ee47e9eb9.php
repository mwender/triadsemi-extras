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

/* reps-and-distributors.twig */
class __TwigTemplate_e77bcbb2c53ddcd5beb5ea75d5b3611710ef06bd29036235fa74c218c3879fe5 extends \Twig\Template
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
        if ( !twig_test_empty(($context["reps_and_distributors"] ?? null))) {
            // line 2
            echo "<table id=\"reps-and-distributors\" class=\"table table-striped\">
  <thead>
    <tr>
      <th>State/Province/County</th>
      <th>Abbr</th>
      <th>Representative/Distributor</th>
    </tr>
  </thead>
  <tbody>
    ";
            // line 11
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["reps_and_distributors"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["row"]) {
                // line 12
                echo "    <tr>
      <td>";
                // line 13
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["row"], "region", [], "any", false, false, false, 13), "html", null, true);
                echo "</td>
      <td>";
                // line 14
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["row"], "abbr", [], "any", false, false, false, 14), "html", null, true);
                echo "</td>
      <td>";
                // line 15
                echo call_user_func_array($this->env->getFilter('shortcodes')->getCallable(), [twig_get_attribute($this->env, $this->source, $context["row"], "contacts", [], "any", false, false, false, 15)]);
                echo "</td>
    </tr>
    ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['row'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 18
            echo "  </tbody>
  <tfoot>
    <tr>
      <th>State/Province/County</th>
      <th>Abbr</th>
      <th>Representative/Distributor</th>
    </tr>
  </tfoot>
</table>
";
        }
    }

    public function getTemplateName()
    {
        return "reps-and-distributors.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  74 => 18,  65 => 15,  61 => 14,  57 => 13,  54 => 12,  50 => 11,  39 => 2,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "reps-and-distributors.twig", "/Users/mwender/webdev/local-lightning/triadsemi.com/app/public/wp-content/plugins/triadsemi-extras/lib/templates/twig/reps-and-distributors.twig");
    }
}
