workflow "New workflow" {
  on = "push"
  resolves = ["Run Composer tests"]
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
