workflow "Run composer tests" {
  resolves = ["Run Composer tests"]
  on = "push"
}

action "Install Composer" {
  uses = "MilesChou/composer-action@master"
  args = "install"
}

action "Run Composer tests" {
  uses = "MilesChou/composer-action@master"
  needs = ["Install Composer"]
  args = "test"
}
