use ext_php_rs::prelude::*;
use regex::Regex;

struct Route {
    path: String,
    expression: Regex,
}

#[php_class]
pub struct AppRust {
    routes: Vec<String>,
    routes_prepared: Vec<Route>,
}

#[php_impl]
impl AppRust {
    pub fn __construct(routes: Vec<String>) -> Self {
        Self {
            routes,
            routes_prepared: Vec::new(),
        }
    }

    pub fn build(&mut self) {
        let regex = Regex::new(r":[^/]+").unwrap();
        for route in self.routes.iter() {
            let pattern = regex.replace_all(&route, "([^/]+)");
            self.routes_prepared.push(Route {
                path: route.clone(),
                expression: Regex::new(&pattern).unwrap(),
            });
        }
    }

    pub fn matches(&self, url: String) -> Option<String> {
        for route in self.routes_prepared.iter() {
            if route.expression.is_match(&url) {
                return Some(route.path.clone());
            }
        }

        None
    }
}

#[php_module]
pub fn get_module(module: ModuleBuilder) -> ModuleBuilder {
    module
}
