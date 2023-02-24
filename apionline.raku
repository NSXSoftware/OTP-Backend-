use HTTP::Server;

my $server = HTTP::Server.new(
    :host<localhost>,
    :port(8000),
    :app(sub (%env) {
        return [
            200,
            [Content-Type => "text/plain"],
            ["API Online starting PHP"]
        ];
    })
);
$server.start;
