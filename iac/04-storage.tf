resource "aws_s3_bucket" "victordev1_bucket" {
    bucket = "victordev1-s3-file-storage"

    tags = {
        Name = "victordev1_bucket"
        Project = "victordev1"
    }
}

resource "aws_s3_bucket_acl" "victordev1_bucket_acl" {
    bucket = aws_s3_bucket.victordev1_bucket.id
    acl    = "private"
}
