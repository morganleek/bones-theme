import apiFetch from '@wordpress/api-fetch';
// import { addQueryArgs } from '@wordpress/url';
import { useState, useEffect, useCallback, useRef } from "@wordpress/element";
import { useForm, SubmitHandler } from 'react-hook-form';
import { debounce, result } from "lodash";
import classNames from "classnames";

const App = () => {
	const [showSearch, setShowSearch] = useState( false );
	const [searchTerm, setSearchTerm] = useState( '' );
	const [results, setResults] = useState( null );
	const [inSearch, setInSearch] = useState( false );
	const containerRef = useRef( null );

	useEffect( () => {
		if ( ! showSearch ) return;
		const handleClickOutside = ( event ) => {
			if ( containerRef.current && ! containerRef.current.contains( event.target ) ) {
				setShowSearch( false );
			}
		};
		document.addEventListener( 'mousedown', handleClickOutside );
		return () => document.removeEventListener( 'mousedown', handleClickOutside );
	}, [ showSearch ] );

	const handleSearch = ( newSearchTerm ) => {
		setSearchTerm( newSearchTerm );
		setInSearch( true );
		apiFetch( 
			{ 
				path: "/bones/v1/search?search=" + newSearchTerm 
			} 
		).then( data => {
				setInSearch( false );
				setResults( data );
		} );
	}

	return (
		<div ref={ containerRef }>
			<button
				className="toggle-search"
				onClick={ () => {
					setShowSearch( !showSearch );
				 } }	
				aria-label="Open Search"
			>
				<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640"><path d="M480 272C480 317.9 465.1 360.3 440 394.7L566.6 521.4C579.1 533.9 579.1 554.2 566.6 566.7C554.1 579.2 533.8 579.2 521.3 566.7L394.7 440C360.3 465.1 317.9 480 272 480C157.1 480 64 386.9 64 272C64 157.1 157.1 64 272 64C386.9 64 480 157.1 480 272zM272 416C351.5 416 416 351.5 416 272C416 192.5 351.5 128 272 128C192.5 128 128 192.5 128 272C128 351.5 192.5 416 272 416z"/></svg>
			</button>
			{/* { showSearch && ( */}
			<div className={ classNames( 
				"search-results", 
				{ "in-search": inSearch }, 
				{ "is-visible": showSearch } 
			) }>
				<div className="top">
					<SearchForm onSearch={ handleSearch } />
				</div>
				{ results && (
					<div className="bottom">
						<p>
							Search results for <span>'{ searchTerm }'</span><br />
							Showing { results?.postCount } of { results?.totalResults } results
						</p>
						{ results.results && (
							<ul className="results">
								{ results.results.map( ( { id, image, label, postType, url }) => (
									<li key={ "search-result-" + id }>
										<div className="thumbnail" dangerouslySetInnerHTML={{__html: image }}></div>
										<div className="content">
											<p className="has-overline-font-size">{ postType }</p>
											<h6>{ label }</h6>
										</div>
										<a href={ url } />
									</li>
								) ) }
							</ul>
						) }
						<div className="wp-block-buttons is-layout-flex wp-block-buttons-is-layout-flex">
							<div className="wp-block-button has-icon__arrow-right">
								<a className="wp-block-button__link wp-element-button" href={ "/?s=" + searchTerm }>
									Show all results
								</a>
							</div>
						</div>
					</div>
				) }
			</div>
			{/* ) } */}
		</div>
	)
}

export const SearchForm = ({ onSearch }) => {
	const { register, handleSubmit } = useForm();
	const searchRef = useRef(null);

	useEffect( () => {
		searchRef.current.focus();
	}, [] );

	const handleSearch = useCallback(
		debounce((searchTerm) => {
			onSearch(searchTerm);
		}, 300), 
		[onSearch]
	);

	const handleChange = (event) => {
		const searchTerm = event.target.value;
		handleSearch(searchTerm);
	};

	const onSubmit = async () => {
		// do nothing when enter is hit
		// async request which may result error
		try {
			// await fetch()
		} catch (e) {
			// handle your error
		}
	}

	return (
		<form
			onSubmit={ handleSubmit( onSubmit ) }
		>
			<input
				type="search"
				name="s"
				placeholder="Search"
				{...register("search", {
						onChange: (e) => handleChange(e)
				})}
				ref={ searchRef }
			/>
			<button aria-label="Search">
				<svg width="21" height="21" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M16.031 14.617L20.314 18.899L18.899 20.314L14.617 16.031C13.0237 17.3082 11.042 18.0029 9 18C4.032 18 0 13.968 0 9C0 4.032 4.032 0 9 0C13.968 0 18 4.032 18 9C18.0029 11.042 17.3082 13.0237 16.031 14.617ZM14.025 13.875C15.2938 12.5697 16.0025 10.8204 16 9C16 5.133 12.867 2 9 2C5.133 2 2 5.133 2 9C2 12.867 5.133 16 9 16C10.8204 16.0025 12.5697 15.2938 13.875 14.025L14.025 13.875Z" fill="white"/>
				</svg>
			</button>
		</form>
	);
};

export default App;