using Microsoft.AspNetCore.Mvc;

namespace Esteticao.Controllers
{
    public class ClientesController : Controller
    {
        public IActionResult Index()
        {
            return View();
        }
    }
}
