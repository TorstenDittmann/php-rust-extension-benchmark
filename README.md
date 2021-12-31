The purpose of this library is to test out the advantages of a PHP extension written in Rust over the native PHP implementation.

> This experiment uses the [ext-php-rs
](https://crates.io/crates/ext-php-rs) crate.

The scenario we are testing is matching a URL against a list of endpoints including placeholders which is used in [utopia-php/framework](https://github.com/utopia-php/framework).

# Usage

First you need to compile the Rust code to a PHP extension. It is important to use the `--release` flag (performance wise)!
```sh
cargo build --release
```

To execute the benchmark you need PHP installed locally.

```sh
# Linux
php -dextension=./target/release/libphp_utopia.so test.php
# macOS
php -dextension=./target/release/libphp_utopia.dylib test.php
```
# Usage (Docker)

You can also run the benchmark without the previous steps using Docker:

```sh
# build
docker build -t php-rust-extenstion-benchmark .
# run
docker run php-rust-extenstion-benchmark
```
# Example Benchmark Results
> Run on an Apple MacBook Pro 13" 2020 M1 using the Dockerfile

```
-------------------------
starting native.
-------------------------
run 0
run 1
run 2
run 3
run 4
run 5
run 6
run 7
run 8
run 9
-------------------------
native took 2.2196494817734 seconds in average per run.
-------------------------
-------------------------
starting rust.
-------------------------
run 0
run 1
run 2
run 3
run 4
run 5
run 6
run 7
run 8
run 9
-------------------------
rust took 0.30620512962341 seconds in average per run.
-------------------------
```
