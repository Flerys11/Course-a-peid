
                <!-- Dashboard -->
                @if(Auth::check())
                    @if(Auth::user()->role === 'admin')
                    <li class="menu-item active">
                        <a href="{{ route('classement.index') }}" class="menu-link">
                            <div data-i18n="Analytics">Classement</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{ route('etape.liste') }}" class="menu-link">
                            <div data-i18n="Blank">Liste Etape</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{ route('liste.penalite') }}" class="menu-link">
                            <div data-i18n="Blank">Penalité</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="{{ route('d.all') }}" class="menu-link">
                            <div data-i18n="Blank">Delete all</div>
                        </a>
                    </li>



                    @elseif(Auth::user()->role === 'equipe')
                        <li class="menu-item active">
                            <a href="{{ route('classement.index') }}" class="menu-link">

                                <div data-i18n="Analytics">Classement</div>
                            </a>
                        </li>
                        <li class="menu-item">
                            <a href="{{ route('etape.index') }}" class="menu-link">
                                <div data-i18n="Blank">Liste Etape</div>
                            </a>
                        </li>
                    @endif
                @endif


