FROM php:8.0-cli

WORKDIR /usr/local/src/
COPY . .

RUN apt-get update && apt-get install -y clang
RUN curl https://sh.rustup.rs -sSf | bash -s -- -y
ENV PATH="/root/.cargo/bin:${PATH}"

RUN cargo build --release
RUN mv /usr/local/src/target/release/libphp_utopia.so /usr/local/lib/php/extensions/no-debug-non-zts-20200930/
RUN echo extension=libphp_utopia.so >> /usr/local/etc/php/conf.d/libphp_utopia.ini

CMD [ "php", "test.php" ]

