use ext_php_rs::prelude::*;
use lazy_static::lazy_static;
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
        fn prepare_routes(route: &String) -> Route {
            lazy_static! {
                static ref REGEX: Regex = Regex::new(r":[^/]+").unwrap();
            }
            let pattern = REGEX.replace_all(&route, "([^/]+)");
            Route {
                path: route.clone(),
                expression: Regex::new(&pattern).unwrap(),
            }
        }
        self.routes_prepared = self.routes.iter().map(|route| prepare_routes(route)).collect();
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
