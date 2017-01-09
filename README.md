# git

Currently pre alpha status.

Some command ideas:

    git diff --stat $oldTag
    git log --no-merge $oldTag..  
    git log --pretty=format:'%h -%d %s (%ci) <%an>' --abbrev-commit --no-merges $oldTag..
