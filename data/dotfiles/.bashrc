#
# ~/.bashrc
#

[[ $- != *i* ]] && return

# ---- Environment ----
export EDITOR="vim"
export HISTCONTROL=ignoredups:erasedups
export HISTSIZE=10000
export HISTFILESIZE=20000
shopt -s histappend checkwinsize autocd cdspell globstar
set -o vi  # vi-style editing

RESET='\[\e[0m\]'
FG_LIGHT1='\[\e[38;2;235;219;178m\]'
YELLOW='\[\e[38;2;250;189;47m\]'
ORANGE='\[\e[38;2;254;128;25m\]'
BLUE='\[\e[38;2;131;165;152m\]'
AQUA='\[\e[38;2;142;192;124m\]'
GREEN='\[\e[38;2;184;187;38m\]'
RED='\[\e[38;2;251;73;52m\]'

PS1="${GREEN}\u${RESET}@${AQUA}\h${RESET}:${BLUE}\w${RESET}\n${ORANGE}\$ ${RESET}"

# ---- Aliases ----
alias grep="grep --color=auto"
alias ll="exa -al --color=auto --icons=always"
alias la="exa -A --color=auto --icons=always"
alias l="exa -CF --color=auto --icons=always"
alias tree="exa --tree --color=auto --icons=always"
alias ls="exa --color=auto --icons=always"
alias df="df -h"
alias du="du -h"
alias open="xdg-open"
alias resource="source ~/.bashrc"
alias cls="clear"
alias mkdir="mkdir -pv"
alias ..="cd .."
alias ...="cd ../.."

# custom
alias connect-to-laptop="ssh lexi@arch-server"
alias file_uploader="/usr/bin/python /usr/bin/file_uploader.py"

# safer
alias cp="cp -i"
alias mv="mv -i"
alias rm="rm -i"

# ---- Functions ----
find-port() {
  [[ -z $1 ]] && { echo "Usage: find-port <port>"; return 1; }
  sudo lsof -t -i ":$1"
}

kill-port() {
  [[ -z $1 ]] && { echo "Usage: kill-port <port>"; return 1; }
  sudo lsof -t -i ":$1" | xargs -r sudo kill -9
}

extract() {
  [[ ! -f $1 ]] && { echo "'$1' is not a valid file"; return 1; }
  case $1 in
    *.tar.bz2)   tar xjf "$1"   ;;
    *.tar.gz)    tar xzf "$1"   ;;
    *.tar.xz)    tar xJf "$1"   ;;
    *.tar)       tar xf "$1"    ;;
    *.bz2)       bunzip2 "$1"   ;;
    *.gz)        gunzip "$1"    ;;
    *.xz)        unxz "$1"      ;;
    *.zip)       unzip "$1"     ;;
    *.7z)        7z x "$1"      ;;
    *)           echo "Cannot extract '$1'" ;;
  esac
}

mkcd() { mkdir -p "$1" && cd "$1"; }
serve() { python3 -m http.server "${1:-8000}"; }
path() { echo -e "${PATH//:/\n}"; }

commit() {
  local scopes=("feat" "fix" "docs" "style" "refactor" "perf" "test" "build" "ci" "chore" "revert")
  if [[ -z "$1" ]]; then
    echo "Usage: commit <type>: <scope>: <message>"
    return 1
  fi

  local type scope message
  IFS=':' read -r type scope message <<< "$1"

  if [[ -z "$type" || -z "$scope" || -z "$message" ]]; then
    echo "Error: Please use the format '<type>:<scope>:<message>'"
    return 1
  fi

  if [[ ! " ${scopes[@]} " =~ " ${scope} " ]]; then
    echo "Error: Invalid scope '$scope'"
    return 1
  fi

  git commit -m "${type}: (${scope}) ${message}"
}


bind '"\C-l":clear-screen'

export PATH=$HOME/.npm-global/bin:$PATH
export PATH="/home/lrr/.config/herd-lite/bin:$PATH"
export PHP_INI_SCAN_DIR="/home/lrr/.config/herd-lite/bin:$PHP_INI_SCAN_DIR"
