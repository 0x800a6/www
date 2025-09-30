" ============================================
" Basic settings
" ============================================
set nocompatible              " Disable vi compatibility
set number                    " Show absolute line numbers
set relativenumber            " Show relative line numbers
syntax on                     " Enable syntax highlighting
set tabstop=4                 " Number of spaces per tab
set shiftwidth=4              " Indent size
set expandtab                 " Convert tabs to spaces
set smartindent               " Auto-indent new lines
set mouse=a                   " Enable mouse in all modes
set clipboard=unnamedplus     " Use system clipboard

" ============================================
" Leader key
" ============================================
let mapleader=","             " Leader key is now ","

" ============================================
" Key mappings
" ============================================
" Open terminal
nnoremap <leader>t :terminal<CR>
vnoremap <leader>t :terminal<CR>
inoremap <leader>t <Esc>:terminal<CR>

" Open custom keys script
nnoremap <leader>h :terminal /home/lrr/.vim/keys.sh<CR>

" COC autocomplete navigation
inoremap <silent><expr> <TAB> pumvisible() ? "\<C-n>" : "\<TAB>"
inoremap <silent><expr> <S-TAB> pumvisible() ? "\<C-p>" : "\<S-TAB>"

" Easier saving and quitting
nnoremap <leader>w :w<CR>
nnoremap <leader>q :q<CR>
nnoremap <leader>x :x<CR>

" Toggle NERDTree
nnoremap <leader>n :NERDTreeToggle<CR>

" ============================================
" Plugins via vim-plug
" ============================================
call plug#begin('~/.vim/plugged')

" Colorscheme
Plug 'morhetz/gruvbox'

" Language server + autocomplete
Plug 'neoclide/coc.nvim', {'branch': 'release'}

" GitHub Copilot
Plug 'github/copilot.vim'

" File explorer
Plug 'preservim/nerdtree'

" Status line
Plug 'itchyny/lightline.vim'

" Fuzzy finder
Plug 'junegunn/fzf', { 'do': { -> fzf#install() } }
Plug 'junegunn/fzf.vim'

" Commenting utility
Plug 'tpope/vim-commentary'

call plug#end()

" ============================================
" Appearance
" ============================================
set background=dark
colorscheme gruvbox
set cursorline                " Highlight current line
set showmatch                 " Highlight matching brackets
set laststatus=2              " Always show status line

" Lightline settings
let g:lightline = {
      \ 'colorscheme': 'gruvbox',
      \ }

" ============================================
" NERDTree settings
" ============================================
let NERDTreeShowHidden=1       " Show hidden files by default
let NERDTreeMinimalUI=1        " Minimal UI


" ============================================
" GitHub Copilot
" ============================================

" Enable Copilot
let g:copilot_no_tab_map = v:true    " Disable default <Tab> mapping
let g:copilot_assume_mapped = v:true " Map keys manually

" Map keys for accepting and cycling suggestions
" Accept suggestion

inoremap <silent> <C-J> <Plug>(copilot-accept)

" Cycle through suggestions
inoremap <silent> <C-K> <Plug>(copilot-next)
inoremap <silent> <C-L> <Plug>(copilot-previous)

" Open Copilot panel
nnoremap <leader>cp :Copilot panel<CR>

