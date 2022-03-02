import * as React from 'react';
import { useState, useEffect } from 'react';
import MetaEditForm from '../../Components/Token/MetaEditForm';
import PostEditPage from '../../Pages/PostEditPage';
import { PostEditPageProps } from '../../Pages/PostEditPage';

export interface MetaEditPageProps extends PostEditPageProps {
	post: any;
}

export default function MetaEditPage( props: MetaEditPageProps ) {
	const meta = Object.assign( {}, props.post );
	const index = meta.index ?? null;
	const asset = meta.asset ?? {
		address: '',
		index: '',
	};
	let blockchain = meta.blockchain;
	if ( !blockchain ) {
		blockchain = 'bitcoin';
	}
	const protocol = meta.protocol ?? null;
	let attributes = Object.assign( [], props.post?.attributes );
	if ( attributes && Array.isArray( attributes ) ) {
		attributes = attributes.filter( function ( item: any ) {
			return item != null;
		} );
	} else {
		attributes = [];
	}
	const media = Object.assign( [], props.post?.media );
	const [ editData, setEditData ] = useState<any>( {
		asset: asset,
		index: index,
		attributes: attributes,
		media: media,
		blockchain: blockchain,
		protocol: protocol,
	} );
	function onEditDataChange( newData: any ) {
		setEditData( newData );
		props.onPostDataChange( newData );
	}

	function onMetaChange( newData: any ) {
		let state = Object.assign( {}, editData );
		state = Object.assign( state, newData );
		onEditDataChange( state );
	}

	useEffect( () => {
		props.onPostDataChange( editData );
	}, [] );

	return (
		<PostEditPage
			onPostDataChange= { props.onPostDataChange }
			tca_enabled={ props.tca_enabled }
			tca_rules={ props.tca_rules }
		>
			<MetaEditForm
				onChange={ onMetaChange }
				editData={ editData }
			/>
		</PostEditPage>
	);
}
