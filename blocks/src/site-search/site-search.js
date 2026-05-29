import apiFetch from '@wordpress/api-fetch';
// import { addQueryArgs } from '@wordpress/url';
import { useState, useEffect, useCallback, useRef } from "@wordpress/element";
import { useForm, SubmitHandler } from 'react-hook-form';
import { debounce, result } from "lodash";

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
				<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M19.6 21L13.3 14.7C12.8 15.1 12.225 15.4167 11.575 15.65C10.925 15.8833 10.2333 16 9.5 16C7.68333 16 6.146 15.3707 4.888 14.112C3.63 12.8533 3.00067 11.316 3 9.5C2.99933 7.684 3.62867 6.14667 4.888 4.888C6.14733 3.62933 7.68467 3 9.5 3C11.3153 3 12.853 3.62933 14.113 4.888C15.373 6.14667 16.002 7.684 16 9.5C16 10.2333 15.8833 10.925 15.65 11.575C15.4167 12.225 15.1 12.8 14.7 13.3L21 19.6L19.6 21ZM9.5 14C10.75 14 11.8127 13.5627 12.688 12.688C13.5633 11.8133 14.0007 10.7507 14 9.5C13.9993 8.24933 13.562 7.187 12.688 6.313C11.814 5.439 10.7513 5.00133 9.5 5C8.24867 4.99867 7.18633 5.43633 6.313 6.313C5.43967 7.18967 5.002 8.252 5 9.5C4.998 10.748 5.43567 11.8107 6.313 12.688C7.19033 13.5653 8.25267 14.0027 9.5 14Z" fill="#152030"/>
				</svg>
			</button>
			{ showSearch && (
				<div className={ "search-results " + (inSearch ? "in-search" : "" ) }>
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
			) }
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